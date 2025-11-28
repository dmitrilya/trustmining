<?php

namespace App\Models\Ad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hosting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ordering_id',
        'user_id',
        'description',
        'address',
        'video',
        'price',
        'images',
        'contract',
        'contract_deficiencies',
        'territory',
        'energy_supply',
        'peculiarities',
        'expenses',
        'conditions',
        'moderation'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'contract_deficiencies',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'images' => 'array',
        'contract_deficiencies' => 'array',
        'peculiarities' => 'array',
        'expenses' => 'array',
        'conditions' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }

    public function moderations()
    {
        return $this->morphMany(\App\Models\Morph\Moderation::class, 'moderationable');
    }

    public function views()
    {
        return $this->morphMany(\App\Models\Morph\View::class, 'viewable');
    }
}