<?php

namespace App\Http\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;

use App\Models\User\User;

trait ShopTrait
{
    public function getShops($request)
    {
        $users = User::where(
            fn(Builder $q) => $q->whereHas('ads', fn(Builder $query) => $query->where('moderation', 'false')->where('hidden', 'false'))
                ->orWhereHas('hosting', fn(Builder $query) => $query->where('moderation', 'false'))
        )->select(['id', 'name', 'url_name', 'tf'])->withCount(['offices' => fn(Builder $query) => $query->where('moderation', false)])
            ->with(['company:user_id,bg_logo,card,moderation', 'moderatedReviews:reviewable_id,reviewable_type,rating']);

        if ($request->city) $users = $users->whereHas(
            'offices',
            fn(Builder $query) =>
            $query->where('moderation', false)->where('address', 'like', '%' . $request->city . '%')
        );

        if ($request->filled('is_company')) $users = $users->whereHas('company', function (Builder $query) {
            $query->where('moderation', false);
        });

        if ($request->sort && ($user = $request->user()) && $user->tariff)
            switch ($request->sort) {
                case 'tf_low_to_high':
                    $users = $users->orderBy('tf');
                    break;
                case 'tf_high_to_low':
                    $users = $users->orderByDesc('tf');
                    break;
            }
        else $users = $users->inRandomOrder();

        return $users;
    }
}
