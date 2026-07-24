<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\CoolingType;

class AsicPSU extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'asic_brand_id',
        'name',
        'revision',
        'power_connector',
        'voltage_min',
        'voltage_max',
        'frequency_min',
        'frequency_max',
        'output_power',
        'efficiency',
        'cooling_type',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'cooling_type' => CoolingType::class,
    ];

    public function asicBrand()
    {
        return $this->belongsTo(\App\Models\Database\AsicBrand::class);
    }
}
