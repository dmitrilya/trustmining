<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsicVersion extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'asic_model_id',
        'hashrate',
        'efficiency',
        'measurement',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'hashrate' => 'double',
    ];

    public function asicModel()
    {
        return $this->belongsTo(\App\Models\Database\AsicModel::class);
    }

    public function ads()
    {
        return $this->hasMany(\App\Models\Ad\Ad::class);
    }
}
