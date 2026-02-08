<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GPUEngineBrand extends Model
{
    use HasFactory;

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

    public function gpuEngineModels()
    {
        return $this->hasMany(\App\Models\Database\GPUEngineModel::class);
    }
}
