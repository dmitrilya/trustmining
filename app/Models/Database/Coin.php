<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'rate',
        'difficulty',
        'fee',
        'reward_block',
    ];

    public function algorithm()
    {
        return $this->belongsTo(\App\Models\Database\Algorithm::class);
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
