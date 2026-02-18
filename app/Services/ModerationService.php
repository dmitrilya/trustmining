<?php

namespace App\Services;

use App\Models\Morph\Moderation;

class ModerationService
{
    public function store(string $type, int $id, array $data): Moderation
    {
        return Moderation::create([
            'moderationable_type' => $type,
            'moderationable_id' => $id,
            'data' => $data
        ]);
    }
}
