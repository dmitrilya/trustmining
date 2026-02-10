<?php

namespace App\Models\Database;

use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GPUModel extends Model
{
    use HasFactory, Searchable;

    protected $table = 'gpu_models';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'gpu_brand_id',
        'gpu_engine_model_id',
        'name',
        'max_power',
        'phases',
        'fuel_consumption',
        'length',
        'width',
        'height',
        'weight',
        'images',
    ];

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
            'gpu_engine_brand.name' => '',
            'gpu_engine_model.name' => '',
            'gpu_brands.name' => ''
        ];
    }

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'images' => 'array',
    ];

    public function gpuBrand()
    {
        return $this->belongsTo(\App\Models\Database\GPUBrand::class);
    }

    public function gpuEngineModel()
    {
        return $this->belongsTo(\App\Models\Database\GPUEngineModel::class);
    }

    public function ads()
    {
        return $this->hasMany(\App\Models\Ad\Ad::class, 'gpu_model_id', 'id');
    }

    public function reviews()
    {
        return $this->morphMany(\App\Models\Morph\Review::class, 'reviewable');
    }

    public function moderatedReviews()
    {
        return $this->reviews()->where('moderation', false);
    }
}
