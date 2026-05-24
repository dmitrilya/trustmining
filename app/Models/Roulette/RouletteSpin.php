<?php

namespace App\Models\Roulette;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouletteSpin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'roulette_prize_id',
        'device_uuid',
    ];

    public function roulettePrize()
    {
        return $this->belongsTo(\App\Models\Roulette\RoulettePrize::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }
}
