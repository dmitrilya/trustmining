<?php

namespace App\Enums;

enum FirmwareModeStrainLevel: int
{
    case Safe = 1;
    case Optimal = 2;
    case Extreme = 3;

    public function name(): string
    {
        return match ($this) {
            self::Safe => 'safe',
            self::Optimal => 'optimal',
            self::Extreme => 'extreme',
        };
    }

    public function text(): string
    {
        return match ($this) {
            self::Safe => 'text-emerald-600 dark:text-emerald-400',
            self::Optimal => 'text-amber-600 dark:text-amber-400',
            self::Extreme => 'text-rose-600 dark:text-rose-400',
        };
    }

    public function bg(): string
    {
        return match ($this) {
            self::Safe => 'bg-emerald-500/10',
            self::Optimal => 'bg-amber-500/10',
            self::Extreme => 'bg-rose-500/10',
        };
    }
}
