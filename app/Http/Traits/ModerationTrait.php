<?php

namespace App\Http\Traits;

use App\Models\Moderation;

trait ModerationTrait
{
    public function getModerations($request)
    {
        $moderations = Moderation::where('moderation_status_id', 1)->select(['id', 'moderationable_type', 'moderationable_id', 'created_at'])
            ->with(['moderationable:id,user_id', 'moderationable.user:id,name,tariff_id', 'moderationable.user.company:user_id,logo']);

        if ($request->model)
            $moderations = $moderations->where('moderationable_type', 'like', '%' . $request->model);

        return $moderations;
    }
}
