<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GPUEngineBrand extends Model
{
    use HasFactory;

    protected $table = 'gpu_engine_brands';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'country',
    ];

    public function gpuEngineModels()
    {
        return $this->hasMany(\App\Models\Database\GPUEngineModel::class, 'gpu_engine_brand_id', 'id');
    }
}
