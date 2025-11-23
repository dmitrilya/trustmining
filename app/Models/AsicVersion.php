<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsicVersion extends Model
{
    use HasFactory;

    public $timestamps = false;

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
        return $this->belongsTo(AsicModel::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
}
