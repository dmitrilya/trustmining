<?php

namespace App\Models\Hosting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'city_id',
        'video',
        'images',
        'contract',
        'contract_deficiencies',
        'territory',
        'energy_supply',
        'tariffs',
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
        'tariffs' => 'array',
        'peculiarities' => 'array',
        'expenses' => 'array',
        'conditions' => 'array',
    ];

    protected $with = ['cityRelation'];

    protected function city(): Attribute
    {
        $locale = app()->getLocale();

        return Attribute::make(
            get: fn() => $this->cityRelation->name[$locale] ?? $this->cityRelation->name['en']
        );
    }

    protected function cityWhere(): Attribute
    {
        $locale = app()->getLocale();

        return Attribute::make(
            get: fn() => $this->cityRelation->name_where[$locale] ?? $this->cityRelation->name_where['en'] ?? $this->city
        );
    }

    public function cityRelation()
    {
        return $this->belongsTo(\App\Models\City::class, 'city_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }

    public function hostingCapacities()
    {
        return $this->hasMany(HostingCapacity::class);
    }

    public function hostingCapacity()
    {
        return $this->hasOne(HostingCapacity::class)->latestOfMany();
    }

    public function hostingExpansions()
    {
        return $this->hasMany(HostingExpansion::class);
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
