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
            self::High => 'bg-blue-50 dark:bg-blue-950/20 border-blue-200 dark:border-blue-900/50 text-blue-900 dark:text-blue-300',
            self::Medium => 'bg-amber-500/10 border-amber-500/30 text-amber-500',
            self::Low => 'bg-rose-500/10 border-rose-500/30 text-rose-500',
        };
    }
}
