<?php

namespace App\Services\Notification\Filters;

use Carbon\Carbon;

class DifficultyChangingFilter implements NotificationFilterInterface
{
    public function check(array $settings, $coin): bool
    {
        $difficulties = $coin->networkDifficulties()->latest()->take(2)->get();
        $pd = $difficulties[1]->difficulty;
        $cd = $difficulties[0]->difficulty;

        if ($pd != $cd) return $settings['frequency'] == 'change';

        $now = now();
        $frequencies = ['12h'];

        if ($now->hour === 10) {
            $frequencies[] = 'd';

            if ($now->diffInDays(Carbon::parse('2026-01-01')) % 3 === 0) $frequencies[] = '3d';
        }

        return in_array($settings['frequency'], $frequencies);
    }
}
