<?php

namespace App\Models\Metrics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinRate extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'coin_id',
        'rate',
        'created_at',
    ];

    public function coin()
    {
        return $this->belongsTo(\App\Models\Database\Coin::class);
    }
}
