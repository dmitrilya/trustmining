<?php

namespace App\Services;

use App\Models\Roulette\RoulettePrize;
use App\Models\Roulette\RouletteSpin;
use App\Models\User\User;
use Illuminate\Support\Facades\Cache;

class RouletteService
{
    /**
     * Get random prize considering the drop chance.
     *
     * @return \App\Models\Roulette\RoulettePrize
     */
    public function getPrize(): RoulettePrize
    {
        $prizes = RoulettePrize::whereNotNull('activated_at')->whereNull('deactivated_at')->with(['user:id', 'user.company:user_id,logo'])->get();

        $totalChance = $prizes->sum('chance');
        $randomPoint = mt_rand(1, $totalChance);
        $currentSum = 0;

        foreach ($prizes as $prize) {
            $currentSum += $prize->chance;

            if ($randomPoint <= $currentSum) return $prize;
        }

        return $prizes->last();
    }

    public function prizesExist()
    {
        return RoulettePrize::whereNotNull('activated_at')->whereNull('deactivated_at')->exists();
    }

    public function getPrizes()
    {
        $prizes = RoulettePrize::whereNotNull('activated_at')->whereNull('deactivated_at')
            ->select(['id', 'user_id', 'name', 'caption', 'partner_link', 'chance'])->with(['user:id,name', 'user.company:user_id,logo'])
            ->inRandomOrder()->get();
        $weightedPool = [];

        foreach ($prizes as $prize) {
            $count = (int) round($prize->chance);
            for ($i = 0; $i < $count; $i++) {
                $weightedPool[] = $prize->toArray();
            }
        }

        if (empty($weightedPool)) $weightedPool = $prizes->toArray();

        $countPool = count($weightedPool);
        for ($i = $countPool - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            $temp = $weightedPool[$i];
            $weightedPool[$i] = $weightedPool[$j];
            $weightedPool[$j] = $temp;
        }

        $extendedPrizes = collect();
        for ($meta = 0; $meta < 4; $meta++) {
            foreach ($weightedPool as $prize) {
                $extendedPrizes->push($prize);
            }
        }

        $extendedPrizes = $extendedPrizes->map(function ($p, $i) {
            $p['is_long_title'] = $this->checkIfNameTooWide($p['name']);
            $p['svg_pattern'] = $this->generate($i);
            $p['style'] = $this->getPrizeRarityClasses($p['chance']);

            return $p;
        });

        return ['prizes' => $prizes, 'extended_prizes' => $extendedPrizes];
    }

    /**
     * Вспомогательный метод проверки интервала времени
     * 
     * @param  int|null  $userId
     * @param  string|null  $deviceUuid
     * @return bool
     */
    public function canSpinAgain(int|null $userId, string|null $deviceUuid): bool
    {
        $PERIOD = config('settings.roulette.period', 7);
        $EXTRA_SPIN_NAME = config('settings.roulette.extra_spin_name');

        if ($userId) {
            $lastSpin = RouletteSpin::where('user_id', $userId)->latest()->first();
            if ($lastSpin && !$lastSpin->created_at->addDays($lastSpin->roulettePrize->name === $EXTRA_SPIN_NAME ? 1 : $PERIOD)->isPast())
                return false;
        } elseif ($deviceUuid) {
            $lastSpin = RouletteSpin::where('device_uuid', $deviceUuid)->latest()->first();
            if ($lastSpin && !$lastSpin->created_at->addDays($lastSpin->roulettePrize->name === $EXTRA_SPIN_NAME ? 1 : $PERIOD)->isPast())
                return false;
        }

        return true;
    }

    /**
     * Количество секунд до следующего спина
     * 
     * @return int
     */
    public function timeToSpin(): int
    {
        $user = auth()->user();
        $deviceUuid = request()->cookie('tm_device_uuid');

        if (!$user && !$deviceUuid) return 0;

        $EXTRA_SPIN_NAME = config('settings.roulette.extra_spin_name');
        $PERIOD = config('settings.roulette.period', 7);

        $lastSpin = RouletteSpin::query()->when($user, fn($q) => $q->where('user_id', $user->id))
            ->when(!$user && $deviceUuid, fn($q) => $q->where('device_uuid', $deviceUuid))
            ->with('roulettePrize')->latest()->first();

        if (!$lastSpin) return 0;

        $days = $lastSpin->roulettePrize->name === $EXTRA_SPIN_NAME ? 1 : $PERIOD;
        $unlockTime = $lastSpin->created_at->addDays($days);

        return $unlockTime->isPast() ? 0 : now()->diffInSeconds($unlockTime, false);
    }

    /**
     * Вспомогательный метод проверки интервала времени
     * 
     * @param  int  $userId
     * @return void
     */
    public function compareSpinsAfterLogin(int $userId): void
    {
        $deviceUuid = request()->cookie('tm_device_uuid');

        if ($deviceUuid) {
            $lastSpin = RouletteSpin::where('user_id', $userId)->with('roulettePrize:id,name')->latest()->first();

            if ($lastSpin) {
                $requiredDays = $lastSpin->roulettePrize->name === config('settings.roulette.extra_spin_name') ? 1 : config('settings.roulette.period');

                $blockStart = $lastSpin->created_at;
                $blockEnd = $lastSpin->created_at->copy()->addDays($requiredDays);

                RouletteSpin::whereNull('user_id')->where('device_uuid', $deviceUuid)
                    ->where('created_at', '>', $blockStart)->where('created_at', '<=', $blockEnd)->delete();

                RouletteSpin::whereNull('user_id')->where('device_uuid', $deviceUuid)
                    ->where('created_at', '>', $blockEnd)->update(['user_id' => $userId]);
            } else {
                RouletteSpin::whereNull('user_id')->where('device_uuid', $deviceUuid)->update(['user_id' => $userId]);
            }
        }
    }

    protected function checkIfNameTooWide(string $name): bool
    {
        $longestWord = '';
        $maxLength = 0;

        $words = mb_split('\s+', $name);

        foreach ($words as $word) {
            $wordLength = mb_strlen($word);

            if ($wordLength > $maxLength) {
                $maxLength = $wordLength;
                $longestWord = $word;
            }
        }

        $wideCharsCount = 0;
        $wideChars = ['ш', 'ю', 'ж', 'м', 'ф', 'щ', 'ы', 'ъ', 'ц'];

        $lowercaseWord = mb_strtolower($longestWord);
        $charsCount = mb_strlen($lowercaseWord);

        for ($i = 0; $i < $charsCount; $i++) {
            if (in_array(mb_substr($lowercaseWord, $i, 1), $wideChars, true)) $wideCharsCount++;
        }

        return $maxLength + ($wideCharsCount * 0.25) > 11;
    }

    protected function getPrizeRarityClasses(float $chance): array
    {
        $rarity = [3, 8, 15];

        if ($chance <= $rarity[0]) {
            return [
                'card' => 'bg-gradient-to-b from-red-800/40 to-red-900/20 dark:to-slate-900 shadow-md',
                'border' => 'border-red-500/60',
                'badge' => 'bg-red-500',
                'glow' => 'shadow-[0_0_20px_rgba(239,68,68,0.25)]',
                'patternColor' => '#ef4444'
            ];
        }

        if ($chance <= $rarity[1]) {
            return [
                'card' => 'bg-gradient-to-b from-amber-800/40 to-amber-900/10 dark:to-slate-900 shadow-md',
                'border' => 'border-amber-500/50',
                'badge' => 'bg-amber-500',
                'glow' => 'shadow-[0_0_15px_rgba(217,70,239,0.2)]',
                'patternColor' => '#d946ef'
            ];
        }

        if ($chance <= $rarity[2]) {
            return [
                'card' => 'bg-gradient-to-b from-indigo-800/40 to-indigo-900/10 dark:to-slate-900 shadow-md',
                'border' => 'border-indigo-500/50',
                'badge' => 'bg-indigo-500',
                'glow' => 'shadow-[0_0_12px_rgba(99,102,241,0.15)]',
                'patternColor' => '#6366f1'
            ];
        }

        return [
            'card' => 'bg-white shadow-md dark:bg-slate-900',
            'border' => 'border-slate-500 dark:border-slate-950',
            'badge' => 'bg-slate-500 dark:bg-slate-950',
            'glow' => '',
            'patternColor' => '#475569'
        ];
    }

    protected static function generate(int $cardIndex): string
    {
        return Cache::rememberForever("card_pattern_{$cardIndex}_v1", function () use ($cardIndex) {
            $currentSeed = $cardIndex + 55443;

            $rand = function () use (&$currentSeed) {
                $currentSeed = fmod(($currentSeed * 1664525 + 1013904223), 4294967296);
                return $currentSeed / 4294967296;
            };

            $html = '';
            $trackCount = 20;
            $trackSpacing = 6.5;
            $startYOffset = 6;

            $occupied = array_fill(0, $trackCount, []);

            $tracksOrder = range(0, $trackCount - 1);
            for ($i = count($tracksOrder) - 1; $i > 0; $i--) {
                $j = (int) floor($rand() * ($i + 1));
                $temp = $tracksOrder[$i];
                $tracksOrder[$i] = $tracksOrder[$j];
                $tracksOrder[$j] = $temp;
            }

            for ($i = 0; $i < 62; $i++) {
                $startTrack = $tracksOrder[$i % $trackCount];
                $startX = floor($rand() * 55);

                $segment1 = ($rand() > 0.4) ? (floor($rand() * 12) + 4) : (floor($rand() * 25) + 12);
                $breakX1 = $startX + $segment1;

                if ($breakX1 > 90) continue;

                $isFree1 = true;
                foreach ($occupied[$startTrack] as $range) {
                    if ($startX - 4 < $range['end'] && $breakX1 + 4 > $range['start']) {
                        $isFree1 = false;
                        break;
                    }
                }
                if (!$isFree1) continue;

                $trackDelta = ($rand() > 0.5) ? 1 : 2;
                $dir = ($rand() > 0.5) ? 1 : -1;
                $endTrack = $startTrack + ($dir * $trackDelta);

                $diagWidth = $trackDelta * $trackSpacing;
                $breakX2 = $breakX1 + $diagWidth;

                if ($breakX2 > 95 || $endTrack < 0 || $endTrack >= $trackCount) continue;

                $lengthRoll = $rand();
                if ($lengthRoll > 0.7) {
                    $segment2 = floor($rand() * 8) + 3;
                } elseif ($lengthRoll > 0.3) {
                    $segment2 = floor($rand() * 20) + 15;
                } else {
                    $segment2 = floor($rand() * 40) + 35;
                }

                $endX = min(100, $breakX2 + $segment2);

                $isFree2 = true;
                foreach ($occupied[$endTrack] as $range) {
                    if ($breakX1 - 4 < $range['end'] && $endX + 4 > $range['start']) {
                        $isFree2 = false;
                        break;
                    }
                }
                if (!$isFree2) continue;

                $occupied[$startTrack][] = ['start' => $startX, 'end' => $breakX1];
                $occupied[$endTrack][] = ['start' => $breakX1, 'end' => $endX];

                $y1 = $startYOffset + ($startTrack * $trackSpacing);
                $y2 = $startYOffset + ($endTrack * $trackSpacing);

                $path = "M {$startX} {$y1} L {$breakX1} {$y1} L {$breakX2} {$y2} L {$endX} {$y2}";
                $op = number_format(($rand() * 0.2 + 0.35), 2, '.', '');

                $html .= "<path d=\"{$path}\" fill=\"none\" stroke=\"var(--pattern-color)\" stroke-width=\"0.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\" opacity=\"{$op}\" />";

                if ($segment2 < 12 || $rand() > 0.3) {
                    $html .= "<circle cx=\"{$endX}\" cy=\"{$y2}\" r=\"1.3\" fill=\"#0b0f19\" stroke=\"var(--pattern-color)\" stroke-width=\"0.8\" opacity=\"0.8\" />";
                }
                if ($startX > 5 && $rand() > 0.4) {
                    $html .= "<circle cx=\"{$startX}\" cy=\"{$y1}\" r=\"1.2\" fill=\"var(--pattern-color)\" opacity=\"0.75\" />";
                }
            }

            return $html;
        });
    }
}
