<?php

namespace App\Models\Database;

use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GPUBrand extends Model
{
    use HasFactory;

    protected $table = 'gpu_brands';

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

    public function gpuModels()
    {
        return $this->hasMany(\App\Models\Database\GPUModel::class, 'gpu_brand_id', 'id');
    }

    public function views()
    {
        return $this->morphMany(\App\Models\Morph\View::class, 'viewable');
    }
}
