<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;

use App\Models\User;

trait ShopTrait
{
    public function getShops($request = null)
    {
        $users = User::where(fn(Builder $q) => $q->whereHas('ads', function (Builder $query) {
            $query->where('moderation', 'false')->where('hidden', 'false');
        })->orWhereHas('hosting', function (Builder $query) {
            $query->where('moderation', 'false');
        }))->select(['id', 'name', 'url_name', 'tf'])->withCount(['offices' => function (Builder $query) {
            $query->where('moderation', false);
        }])->with(['company:user_id,logo,moderation', 'moderatedReviews:reviewable_id,reviewable_type,rating']);

        if (!isset($request)) return $users;

        if ($request->city) $users = $users->whereLike('offices.address', '%' . $request->city . '%');

        if ($request->has('is_company')) $users = $users->whereHas('company', function (Builder $query) {
            $query->where('moderation', false);
        });

        if ($request->rating) $users = $users->where('moderatedReviews.avg_rating', '>=', $request->rating);

        if ($request->sort && ($user = $request->user()) && $user->tariff)
            switch ($request->sort) {
                case 'tf_low_to_high':
                    $users = $users->orderBy('tf');
                    break;
                case 'tf_high_to_low':
                    $users = $users->orderByDesc('tf');
                    break;
            }

        return $users;
    }
}
