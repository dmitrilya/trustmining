<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Http\Traits\Searchable;

class AsicBrand extends Model
{
    use HasFactory, Searchable;

    public $timestamps = false;

    public static array $searchWeights = [
        'name' => 1,
    ];

    public static array $searchableDependents = [
        'name' => [
            \App\Models\Database\AsicModel::class => 'asicModels',
            \App\Models\Ad\Ad::class => 'asicModels.asicVersions.ads',
        ],
    ];

    public function asicModels()
    {
        return $this->hasMany(\App\Models\Database\AsicModel::class);
    }

    public function algorithms()
    {
        return $this->hasManyThrough(\App\Models\Database\Algorithm::class, \App\Models\Database\AsicModel::class);
    }

    public function views()
    {
        return $this->morphMany(\App\Models\Morph\View::class, 'viewable');
    }
}
