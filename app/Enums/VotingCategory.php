<?php

namespace App\Enums;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

use App\Enums\VotingPeriod;
use App\Models\User\User;
use App\Models\Database\Coin;

enum VotingCategory: int
{
    case best_hosting = 1;
    case coin_rate_prediction = 2;

    public function name(): string
    {
        $names = [
            'best_hosting' => [
                'en' => 'Vote for the best hosting',
                'ru' => 'Голосование за лучший хостинг'
            ],
            'coin_rate_prediction' => [
                'en' => 'Your price prediction',
                'ru' => 'Ваш прогноз курса'
            ]
        ];

        return match ($this) {
            self::best_hosting => $names['best_hosting'][app()->getLocale()] ?? reset($names['best_hosting']),
            self::coin_rate_prediction => $names['coin_rate_prediction'][app()->getLocale()] ?? reset($names['coin_rate_prediction']),
        };
    }

    public function caption(): string
    {
        $captions = [
            'best_hosting' => [
                'en' => 'Monthly anonymous user voting for the best mining hotel',
                'ru' => 'Ежемесячное анонимное голосование пользователей за лучший майнинг-отель'
            ],
            'coin_rate_prediction' => [
                'en' => 'Will the coin price go up or down this month? Make your anonymous prediction!',
                'ru' => 'Пойдет ли курс монеты вверх или вниз в этом месяце? Сделайте свой прогноз!'
            ]
        ];

        return match ($this) {
            self::best_hosting => $captions['best_hosting'][app()->getLocale()] ?? reset($captions['best_hosting']),
            self::coin_rate_prediction => $captions['coin_rate_prediction'][app()->getLocale()] ?? reset($captions['coin_rate_prediction']),
        };
    }

    public function slug(): string
    {
        return match ($this) {
            self::best_hosting => 'best-hosting',
            self::coin_rate_prediction => 'coin-prediction',
        };
    }

    public static function fromSlug(string $slug): ?self
    {
        foreach (self::cases() as $category) {
            if ($category->slug() === $slug) return $category;
        }

        return null;
    }

    public function period(): VotingPeriod
    {
        return match ($this) {
            self::best_hosting => VotingPeriod::monthly,
            self::coin_rate_prediction => VotingPeriod::weekly,
        };
    }

    public function modelClass(): string
    {
        return match ($this) {
            self::best_hosting => User::class,
            self::coin_rate_prediction => Coin::class,
        };
    }

    public function morphClass(): string|bool
    {
        if ($this === self::coin_rate_prediction) return false;

        return array_search($this->modelClass(), Relation::morphMap());
    }

    public function isUniquePerCandidate(): bool
    {
        return match ($this) {
            self::best_hosting => false,
            self::coin_rate_prediction => true,
        };
    }

    public function applyFilter(Builder $query): Builder
    {
        return match ($this) {
            self::best_hosting => $query->whereHas('hosting', function ($q) {
                $q->where('moderation', false);
            }),

            self::coin_rate_prediction => $query->whereHas('coinRates'),
        };
    }

    public function validateCandidate($model): bool
    {
        $expectedClass = $this->modelClass();

        if (!$model instanceof $expectedClass) return false;

        return match ($this) {
            self::best_hosting => $model->hosting()->where('moderation', false)->exists(),
            self::coin_rate_prediction => (bool) $model->coinRates()->exists(),
        };
    }

    public function mapCandidate($model): array
    {
        return match ($this) {
            self::best_hosting => [
                'id'   => $model->id,
                'name' => $model->name,
                'caption' => __($model->company?->card['type']) ?? __('Private person'),
                'href' => route('company.about', $model->slug),
                'img'  => $model->company?->logo,
            ],
            self::coin_rate_prediction => [
                'id'   => $model->id,
                'name' => $model->name . ' (' . $model->abbreviation . ')',
                'caption' => $model->algorithm?->name,
                'href' => '#', //route('coins.show', $model->slug),
                'img'  => 'public/coins/' . $model->abbreviation . '.webp',
            ],
        };
    }
}
