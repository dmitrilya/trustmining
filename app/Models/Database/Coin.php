<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;

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
