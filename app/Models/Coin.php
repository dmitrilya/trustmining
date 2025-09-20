<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;

    public function algorithm()
    {
        return $this->belongsTo(Algorithm::class);
    }

    public function networkHashrates()
    {
        return $this->hasMany(NetworkHashrate::class);
    }

    public function networkDifficulties()
    {
        return $this->hasMany(NetworkDifficulty::class);
    }
}
