<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkDifficulty extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }
}
