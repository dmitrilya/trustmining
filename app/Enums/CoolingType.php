<?php

namespace App\Enums;

enum CoolingType: int
{
    case Passive = 0;
    case Air = 1;
    case Hydro = 2;
    case Immersion = 3;

    public function name(): string
    {
        return match ($this) {
            self::Passive => 'Passive',
            self::Air => 'Air',
            self::Hydro => 'Hydro',
            self::Immersion => 'Immersion',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Passive => 'fan',
            self::Air => 'fan',
            self::Hydro => 'droplets',
            self::Immersion => 'waves',
        };
    }
}
