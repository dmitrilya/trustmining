<?php

namespace App\Models\Ad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function ads()
    {
        return $this->hasMany(\App\Models\Ad\Ad::class);
    }
}
