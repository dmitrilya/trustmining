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
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'gpu_engine_brand_id',
        'name',
        'volume',
        'cylinders',
        'rpm',
    ];

    public function gpuEngineBrand()
    {
        return $this->belongsTo(\App\Models\Database\GPUEngineBrand::class, 'gpu_engine_brand_id', 'id');
    }

    public function gpuModels()
    {
        return $this->hasMany(\App\Models\Database\GPUModel::class, 'gpu_engine_id', 'id');
    }
}
