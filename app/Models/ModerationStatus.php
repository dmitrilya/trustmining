<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModerationStatus extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function moderations()
    {
        return $this->hasMany(Moderation::class);
    }
}
