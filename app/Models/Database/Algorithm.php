<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Algorithm extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $translatable = ['caption', 'description'];

    public function asicModels()
    {
        return $this->hasMany(\App\Models\Database\AsicModel::class);
    }

    public function coins()
    {
        return $this->hasMany(\App\Models\Database\Coin::class);
    }

    public function views()
    {
        return $this->morphMany(\App\Models\Morph\View::class, 'viewable');
    }
}
