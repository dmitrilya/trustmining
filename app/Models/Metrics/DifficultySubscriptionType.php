<?php

namespace App\Models\Metrics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DifficultySubscriptionType extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function difficultySubscriptions()
    {
        return $this->hasMany(\App\Models\Metrics\DifficultySubscription::class);
    }
}
