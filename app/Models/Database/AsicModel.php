<?php

namespace App\Models\Database;

use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsicModel extends Model
{
    use HasFactory, Searchable;

    public $timestamps = false;

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('name', str_replace('_', ' ', $value))->first() ?? abort(404);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'name' => '',
            'description' => '',
            'algorithms.name' => '',
            'asic_brands.name' => ''
        ];
    }

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'characteristics' => 'array',
        'images' => 'array',
        'release' => 'date',
    ];

    public function algorithm()
    {
        return $this->belongsTo(\App\Models\Database\Algorithm::class);
    }

    public function asicVersions()
    {
        return $this->hasMany(\App\Models\Database\AsicVersion::class);
    }

    public function asicBrand()
    {
        return $this->belongsTo(\App\Models\Database\AsicBrand::class);
    }

    public function ads()
    {
        return $this->hasManyThrough(\App\Models\Ad\Ad::class, \App\Models\Database\AsicVersion::class);
    }

    public function reviews()
    {
        return $this->morphMany(\App\Models\Morph\ReView::class, 'reviewable');
    }

    public function moderatedReviews()
    {
        return $this->reviews()->where('moderation', false);
    }

    public function views()
    {
        return $this->morphMany(\App\Models\Morph\View::class, 'viewable');
    }
}
