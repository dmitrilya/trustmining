<?php

namespace App\Models\Metrics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DifficultySubscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'difficulty_subscription_type_id',
        'user_id',
        'coin_id',
    ];

    public function difficultySubscriptionType()
    {
        return $this->belongsTo(\App\Models\Metrics\DifficultySubscriptionType::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }

    public function coin()
    {
        return $this->belongsTo(\App\Models\Database\Coin::class);
    }
}
