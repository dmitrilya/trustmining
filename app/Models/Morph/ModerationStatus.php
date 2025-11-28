<?php

namespace App\Models\Morph;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModerationStatus extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function moderations()
    {
        return $this->hasMany(\App\Models\Morph\Moderation::class);
    }
}
