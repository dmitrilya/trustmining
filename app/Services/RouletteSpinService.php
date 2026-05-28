<?php

namespace App\Services;

use App\Models\Roulette\RoulettePrize;
use App\Models\Roulette\RouletteSpin;
use App\Models\User\User;

class RouletteSpinService
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
}
