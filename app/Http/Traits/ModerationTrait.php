<?php

namespace App\Http\Traits;

use App\Models\Moderation;

trait ModerationTrait
{
    public function getModerations($request)
    {
        $moderations = Moderation::where('moderation_status_id', 1)
            ->with(['moderationable', 'moderationable.user', 'moderationable.user.company']);

        if ($request->model)
            $moderations = $moderations->where('moderationable_type', 'like', '%' . $request->model);

        return $moderations;
    }
}
