<?php

namespace App\Enums;

use Illuminate\Support\Carbon;

enum VotingPeriod: string
{
    case daily = 'daily';
    case weekly = 'weekly';
    case monthly = 'monthly';
    case quarterly = 'quarterly';
    case yearly = 'yearly';

    public function name(): string
    {
        $names = [
            'daily'     => ['en' => 'Daily', 'ru' => 'Ежедневное'],
            'weekly'    => ['en' => 'Weekly', 'ru' => 'Еженедельное'],
            'monthly'   => ['en' => 'Monthly', 'ru' => 'Ежемесячное'],
            'quarterly' => ['en' => 'Quarterly', 'ru' => 'Ежеквартальное'],
            'yearly'    => ['en' => 'Yearly', 'ru' => 'Ежегодное'],
        ];

        return $names[$this->value][app()->getLocale()] ?? reset($names[$this->value]);
    }

    public function currentRoundId(): int
    {
        $now = Carbon::now();

        return match ($this) {
            self::daily => (int) $now->format('Ymd'),
            self::weekly => (int) ($now->format('Y') . sprintf('%02d', $now->weekOfYear)),
            self::monthly => (int) $now->format('Ym'),
            self::quarterly => (int) ($now->format('Y') . $now->quarter),
            self::yearly => (int) $now->format('Y'),
        };
    }
}
