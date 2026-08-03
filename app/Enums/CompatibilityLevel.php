<?php

namespace App\Enums;

enum CompatibilityLevel: int
{
    case High = 1;
    case Medium = 2;
    case Low = 3;

    public function name(): string
    {
        return match ($this) {
            self::High => 'high',
            self::Medium => 'medium',
            self::Low => 'low',
        };
    }

    public function style(): string
    {
        return match ($this) {
            self::High => 'bg-emerald-500/10 border-emerald-500/30 text-emerald-600 dark:text-emerald-400',
            self::Medium => 'bg-amber-500/10 border-amber-500/30 text-amber-600 dark:text-amber-400',
            self::Low => 'bg-rose-500/10 border-rose-500/30 text-rose-600 dark:text-rose-400',
        };
    }
}
