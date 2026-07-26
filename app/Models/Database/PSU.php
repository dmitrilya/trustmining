<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\CoolingType;

class PSU extends Model
{
    use HasFactory;

    protected $table = 'psus';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'asic_brand_id',
        'name',
        'connector',
        'input_voltage_min',
        'input_voltage_max',
        'frequency_min',
        'frequency_max',
        'output1_voltage_min',
        'output1_voltage_max',
        'output1_rated_current',
        'output2_voltage_min',
        'output2_voltage_max',
        'output2_rated_current',
        'rated_power',
        'cooling_type',
        'notes'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'cooling_type' => CoolingType::class,
    ];

    public function getMaxPowerAttribute(): ?float
{
    if (!$this->output_voltage_max || !$this->output_current_max) return null;

    return round($this->output_voltage_max * $this->output_current_max);
}

    public function asicBrand()
    {
        return $this->belongsTo(\App\Models\Database\AsicBrand::class);
    }

    public function asicModels()
    {
        return $this->belongsToMany(\App\Models\Database\AsicModel::class);
    }
}
