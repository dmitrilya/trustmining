<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GPUEngineModel extends Model
{
    use HasFactory;

    protected $table = 'gpu_engine_models';

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

    public function gpuEngineBrand()
    {
        return $this->belongsTo(\App\Models\Database\GPUEngineBrand::class);
    }

    public function gpuModels()
    {
        return $this->hasMany(\App\Models\Database\GPUModel::class);
    }
}
