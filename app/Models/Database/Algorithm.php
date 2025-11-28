<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Algorithm extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function asicModels()
    {
        return $this->hasMany(\App\Models\Database\AsicModel::class);
    }

    public function coins()
    {
        return $this->hasMany(\App\Models\Database\Coin::class);
    }
}
