<?php

namespace App\Models\Ad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
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
        'ad_category_id',
        'asic_version_id',
        'office_id',
        'description',
        'preview',
        'images',
        'props',
        'price',
        'moderation',
        'coin_id',
        'with_vat'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'images' => 'array',
        'props' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }

    public function adCategory()
    {
        return $this->belongsTo(\App\Models\Ad\AdCategory::class);
    }

    public function asicVersion()
    {
        return $this->belongsTo(\App\Models\Database\AsicVersion::class);
    }

    public function office()
    {
        return $this->belongsTo(\App\Models\User\Office::class);
    }

    public function coin()
    {
        return $this->belongsTo(\App\Models\Database\Coin::class);
    }

    public function moderations()
    {
        return $this->morphMany(\App\Models\Morph\Moderation::class, 'moderationable');
    }

    public function views()
    {
        return $this->morphMany(\App\Models\Morph\View::class, 'viewable');
    }

    public function phoneViews()
    {
        return $this->hasMany(\App\Models\Morph\View::class);
    }

    public function tracks()
    {
        return $this->hasMany(\App\Models\Ad\Track::class);
    }

    public function chats()
    {
        return $this->hasMany(\App\Models\Chat\Chat::class);
    }

    public function trackingUsers()
    {
        return $this->belongsToMany(\App\Models\User\User::class, 'tracks');
    }
}
