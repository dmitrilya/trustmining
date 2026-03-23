<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profit',
        'difficulty',
        'fee',
        'reward_block',
    ];

    protected $with = ['latestRate'];

    protected function rate(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->latestRate?->rate ?? 0,
        );
    }

    public function algorithm()
    {
        return $this->belongsTo(\App\Models\Database\Algorithm::class);
    }

    public function coinRates()
    {
        return $this->hasMany(\App\Models\Metrics\CoinRate::class);
    }

    public function latestRate()
    {
        return $this->hasOne(\App\Models\Metrics\CoinRate::class)->latestOfMany();
    }

    public function networkHashrates()
    {
        return $this->hasMany(\App\Models\Metrics\NetworkHashrate::class);
    }

    public function networkDifficulties()
    {
        return $this->hasMany(\App\Models\Metrics\NetworkDifficulty::class);
    }
}
