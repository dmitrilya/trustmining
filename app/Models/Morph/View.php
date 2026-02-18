<?php

namespace App\Models\Morph;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'viewable_id',
        'viewable_type',
        'viewer',
        'ad_id',
        'count',
        'created_at'
    ];

    public function viewable()
    {
        return $this->morphTo();
    }

    public function ad()
    {
        return $this->belongsTo(\App\Models\Ad\Ad::class);
    }
}
