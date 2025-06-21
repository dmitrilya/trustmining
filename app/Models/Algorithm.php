<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Algorithm extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function asicModels()
    {
        return $this->hasMany(AsicModel::class);
    }

    public function coins()
    {
        return $this->hasMany(Coin::class);
    }
}
