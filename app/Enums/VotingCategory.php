<?php

namespace App\Enums;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Builder;

use App\Models\User\User;

enum VotingCategory: int
{
    case best_hosting = 1;

    public function name(): string
    {
        $names = [
            'best_hosting' => [
                'en' => 'Vote for the best hosting',
                'ru' => 'Голосование за лучший хостинг'
            ]
        ];

        return match ($this) {
            self::best_hosting => $names['best_hosting'][app()->getLocale()] ?? reset($names['best_hosting']),
        };
    }

    public function caption(): string
    {
        $captions = [
            'best_hosting' => [
                'en' => 'Monthly anonymous user voting for the best mining hotel',
                'ru' => 'Ежемесячное анонимное голосование пользователей за лучший майнинг-отель'
            ]
        ];

        return match ($this) {
            self::best_hosting => $captions['best_hosting'][app()->getLocale()] ?? reset($captions['best_hosting']),
        };
    }

    public function slug(): string
    {
        return match ($this) {
            self::best_hosting => 'best-hosting',
        };
    }

    public static function fromSlug(string $slug): ?self
    {
        foreach (self::cases() as $category) {
            if ($category->slug() === $slug) return $category;
        }

        return null;
    }

    public function modelClass(): string
    {
        return match ($this) {
            self::best_hosting => User::class,
        };
    }

    public function morphClass(): string
    {
        return array_search($this->modelClass(), Relation::morphMap());
    }

    public function applyFilter(Builder $query): Builder
    {
        return match ($this) {
            self::best_hosting => $query->whereHas('hosting', function ($q) {
                $q->where('moderation', false);
            }),
        };
    }

    public function validateCandidate($model): bool
    {
        $expectedClass = $this->modelClass();

        if (!$model instanceof $expectedClass) return false;

        return match ($this) {
            self::best_hosting => $model->hosting()->where('moderation', false)->exists(),
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
        };
    }
}
