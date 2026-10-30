<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Http\Traits\Searchable;

class Algorithm extends Model
{
    use HasFactory, Searchable;

    public $timestamps = false;

    public static array $searchableDependents = [
        'name' => [
            \App\Models\Database\AsicModel::class => 'asicModels',
            \App\Models\Ad\Ad::class => 'asicModels.asicVersions.ads',
        ],
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'caption' => 'array',
        'description' => 'array',
    ];

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
