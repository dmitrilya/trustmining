<?php

namespace App\Http\Traits;

use App\Models\User\User;

trait ShopTrait
{
    public function getShops($request)
    {
        $users = User::where(
            fn($q) => $q->whereHas('ads', fn($q1) => $q1->where('moderation', 'false')->where('hidden', 'false'))
                ->orWhereHas('hosting', fn($q1) => $q1->where('moderation', 'false'))
        )->select(['id', 'name', 'url_name', 'tf'])->withCount(['offices' => fn($q) => $q->where('moderation', false)])
            ->with(['company:user_id,bg_logo,card,moderation', 'moderatedReviews:reviewable_id,reviewable_type,rating']);

        if ($request->city) $users = $users->whereHas(
            'offices',
            fn($q) => $q->where('moderation', false)->where('address', 'like', '%' . $request->city . '%')
        );

        if ($request->filled('is_company')) $users = $users->whereHas('company', fn($q) => $q->where('moderation', false));

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
