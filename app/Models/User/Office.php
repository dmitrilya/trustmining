<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Office extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'city_id',
        'address',
        'images',
        'video',
        'postal_code',
        'peculiarities',
        'moderation',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'images' => 'array',
        'peculiarities' => 'array',
    ];

    protected $with = ['cityRelation'];

    protected function city(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->cityRelation->name
        );
    }

    protected function cityWhere(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->cityRelation->name_where
        );
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }

    public function cityRelation()
    {
        return $this->belongsTo(\App\Models\City::class, 'city_id');
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
