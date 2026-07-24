<?php

namespace App\Enums;

enum CoolingType: int
{
    case Air = 1;
    case Hydro = 2;
    case Immersion = 3;

    public function name(): string
    {
        return match ($this) {
            self::Air => 'Air',
            self::Hydro => 'Hydro',
            self::Immersion => 'Immersion',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Air => 'fan',
            self::Hydro => 'droplets',
            self::Immersion => 'waves',
        };
    }
}
