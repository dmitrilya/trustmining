<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TrustFactorService
{
    protected array $config;

    public function __construct()
    {
        $this->config = config('trustfactor');
    }

    public function calculate($user)
    {
        $oldTF = $user->tf ?? null;
        $tf = $this->config['base'];

        // --- 1. Компания ---
        $tf += $this->scoreCompanyData($user);

        // --- 2. Отзывы ---
        $tf += $this->scoreReviews($user);

        // --- 3. Офисы ---
        $tf += $this->scoreOffices($user);

        // --- 4. Уникальность контента ---
        $tf += $this->scoreUniqueContent($user);

        // --- 5. Average Response Time ---
        $tf += $this->scoreResponseTime($user);

        // --- 6. Хостинг ---
        $tf += $this->scoreHosting($user);

        // --- 7. Обрезаем по границам ---
        $tf = max($this->config['min'], min($this->config['max'], $tf));

        $user->tf = $tf;
        $user->save();

        $this->logIfAnomaly($user, $oldTF, $tf);

        return $tf;
    }

    /**
     * COMPANY
     */
    private function scoreCompanyData($user)
    {
        if (!$user->company) {
            return -20;
        }

        $score = 0;
        $card = $user->company->card;

        if ($card['type'] === 'LEGAL') {
            $score += 3;

            if ($card['capital'] > 10000) $score += 2;
            if ($card['branch_count'] > 0) $score += 3;
        }

        // возраст компании
        $years = Carbon::now()->diffInYears(Carbon::createFromTimestampMs($card['state']['registration_date']));

        if ($years > 3)      $score += 5;
        elseif ($years > 2)  $score += 2;
        elseif ($years < 1)  $score -= 3;

        // статус
        if ($card['state']['status'] != 'ACTIVE') {
            $score -= 35;
        }

        // финансы
        if (!empty($card['finance'])) {
            $income = $card['finance']['income'];

            if ($income > 10_000_000_000) $score += 7;
            elseif ($income > 5_000_000_000) $score += 5;
            elseif ($income > 2_000_000_000) $score += 3;
            elseif ($income < 100_000_000)   $score -= 6;
            elseif ($income < 1_000_000_000) $score -= 3;
        }

        // сотрудники
        $emp = $card['employee_count'] ?? 0;

        if ($emp > 10)      $score += 4;
        elseif ($emp > 4)   $score += 2;
        elseif ($emp > 1)   $score += 1;
        else                $score -= 5;

        // некорректные документы
        if (isset($card['invalid'])) {
            $score -= 15;
        }

        // сайт
        if ($user->company->site) $score += 3;

        // видео
        if ($user->company->video) $score += 3;

        // количество фото
        if (count($user->company->images) > 5) $score += 2;

        return $score;
    }

    /**
     * REVIEWS
     */
    private function scoreReviews($user)
    {
        $reviews = $user->moderatedReviews;

        if (!$reviews || $reviews->where('fake', false)->count() <= 2) {
            return 0;
        }

        $fakeCount = $reviews->where('fake', true)->count();
        $real = $reviews->where('fake', false);
        $avg = $real->avg('rating');

        $score = 0;

        if ($avg >= 4.85) $score += 7;
        elseif ($avg >= 4.7) $score += 4;
        elseif ($avg >= 4.4) $score += 1;
        elseif ($avg >= 4.1) $score -= 3;
        elseif ($avg >= 3.9) $score -= 6;
        elseif ($avg >= 3.65) $score -= 10;
        else $score -= 15;

        if ($fakeCount > 0) {
            $score -= 3;
        }

        return $score;
    }

    /**
     * OFFICES
     */
    private function scoreOffices($user)
    {
        $cfg = $this->config['office_bonus'];
        $count = min(count($cfg) - 1, $user->moderatedOffices->count());

        return $cfg[$count];
    }

    /**
     * UNIQUE CONTENT
     */
    private function scoreUniqueContent($user)
    {
        $adsCount = $user->ads->count();

        if ($adsCount == 0) {
            return 0;
        }

        $uniqueCount = $user->ads->where('unique_content')->count();
        $ratio = $uniqueCount / $adsCount;

        if ($ratio >= 0.9)     return 5;
        elseif ($ratio >= 0.75) return 2;
        elseif ($ratio < 0.15)  return -5;
        elseif ($ratio < 0.5)   return -2;

        return 0;
    }

    /**
     * AVERAGE RESPONSE TIME
     */
    private function scoreResponseTime($user)
    {
        $minutes = $user->art;

        if ($minutes < 5)        return 4;
        elseif ($minutes < 10)   return 2;
        elseif ($minutes > 40)   return -4;
        elseif ($minutes > 20)   return -2;

        return 0;
    }

    /**
     * HOSTING
     */
    private function scoreHosting($user)
    {
        if (!$user->hosting) return 0;
        if ($user->hosting->moderation) return 0;

        if (!in_array('Possibility of visiting the territory', $user->hosting->peculiarities)) {
            return -5;
        }

        return 0;
    }

    /**
     * LOGGING
     */
    private function logIfAnomaly($user, $old, $new)
    {
        if ($old === null) {
            Log::channel('trustfactor')->info("[TF INIT] user={$user->id} tf=$new");
            return;
        }

        $diff = abs($old - $new);
        $threshold = $this->config['log_diff_threshold'];

        if ($diff >= $threshold) {
            Log::channel('trustfactor')->warning("[TF ANOMALY] user={$user->id} old=$old new=$new diff=$diff");
        }
    }
}
