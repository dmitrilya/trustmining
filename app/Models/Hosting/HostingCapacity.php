<?php

namespace App\Models\Hosting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostingCapacity extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hosting_id',
        'total',
        'occupied',
    ];

    public function hosting()
    {
        return $this->belongsTo(\App\Models\Hosting\Hosting::class);
    }
}
