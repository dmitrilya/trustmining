<?php

namespace App\Enums;

enum RatingSource: string
{
    case YANDEX_MAPS = 'yandex_maps';
    case GOOGLE_MAPS = 'google_maps';
    case TOP_MINING = 'top_mining';
    case GIS = '2gis';

    public function name(): string
    {
        $names = [
            self::YANDEX_MAPS => ['en' => 'Yandex Maps', 'ru' => 'Яндекс Карты'],
            self::GOOGLE_MAPS => ['en' => 'Google Maps', 'ru' => 'Google Карты'],
            self::GIS => ['en' => '2GIS', 'ru' => '2ГИС'],
            self::TOP_MINING => ['en' => 'Top Mining', 'ru' => 'Топ Майнинг'],
        ];

        return $names[$this->value][app()->getLocale()] ?? reset($names[$this->value]);
    }

    public function logo(): string
    {
        return match ($this) {
            self::YANDEX_MAPS => '/img/sources/yandex.svg',
            self::GOOGLE_MAPS => '/img/sources/google.svg',
            self::GIS        => '/img/sources/2gis.svg',
            self::TOP_MINING => '/img/sources/top-mining.svg',
        };
    }

    public function href(?string $externalId): ?string
    {
        if (empty($externalId)) {
            return null;
        }

        return match ($this) {
            self::YANDEX_MAPS => "https://yandex.ru/maps/org/{$externalId}/reviews",
            self::GOOGLE_MAPS => "https://google.com:{$externalId}",
            self::GIS => "https://2gis.ru/search/{$externalId}/tab/reviews",
            self::TOP_MINING => "https://top-mining.ru/{$externalId}",
        };
    }

    public function ratableModelClass(): string
    {
        return match ($this) {
            self::YANDEX_MAPS, self::GOOGLE_MAPS, self::GIS => \App\Models\User\Office::class,
            self::TOP_MINING => \App\Models\User\User::class,
        };
    }
}
