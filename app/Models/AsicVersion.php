<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsicVersion extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function asicModel()
    {
        return $this->belongsTo(AsicModel::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
}
