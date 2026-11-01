<?php

namespace App\Enums;

enum RatingSource: string
{
    case YANDEX_MAPS = 'yandex_maps';
    case GOOGLE_MAPS = 'google_maps';
    case TOP_MINING = 'top_mining';
    case GIS = '2gis';
    case AVITO = 'avito';

    public function name(): string
    {
        $locale = app()->getLocale();

        return match ($this) {
            self::YANDEX_MAPS => $locale === 'ru' ? 'Яндекс Карты' : 'Yandex Maps',
            self::GOOGLE_MAPS => $locale === 'ru' ? 'Google Карты' : 'Google Maps',
            self::GIS         => $locale === 'ru' ? '2ГИС'         : '2GIS',
            self::TOP_MINING   => $locale === 'ru' ? 'Топ Майнинг'  : 'Top Mining',
            self::AVITO        => $locale === 'ru' ? 'Авито'        : 'Avito',
        };
    }

    public function logo(): string
    {
        return match ($this) {
            self::YANDEX_MAPS => 'yandex-maps.svg',
            self::GOOGLE_MAPS => 'google-maps.svg',
            self::GIS => '2gis.svg',
            self::TOP_MINING => 'top-mining.svg',
            self::AVITO => 'avito.svg',
        };
    }

    public function href(?string $externalId): ?string
    {
        if (empty($externalId)) return null;

        return match ($this) {
            self::YANDEX_MAPS => "https://yandex.ru/maps/org/{$externalId}/reviews",
            self::GOOGLE_MAPS => "https://google.com:{$externalId}",
            self::GIS => "https://2gis.ru/firm/{$externalId}/tab/reviews",
            self::TOP_MINING => "https://top-mining.ru/{$externalId}",
            self::AVITO => "https://www.avito.ru/brands/{$externalId}/all",
        };
    }

    public function ratableModelClass(): string
    {
        return match ($this) {
            self::YANDEX_MAPS, self::GOOGLE_MAPS, self::GIS => \App\Models\User\Office::class,
            self::TOP_MINING, self::AVITO => \App\Models\User\User::class,
        };
    }
}
