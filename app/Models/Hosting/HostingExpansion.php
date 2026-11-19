<?php

namespace App\Models\Hosting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostingExpansion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hosting_id',
        'capacity',
        'planned_at',
        'completed_at',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'planned_at' => 'date:Y-m',
        'completed_at' => 'date:Y-m',
    ];

    public function hosting()
    {
        return $this->belongsTo(\App\Models\Hosting\Hosting::class);
    }
}
