<?php

namespace App\Models;

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
        'new',
        'warranty',
        'in_stock',
        'waiting',
        'price',
        'moderation',
        'coin_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adCategory()
    {
        return $this->belongsTo(AdCategory::class);
    }

    public function asicVersion()
    {
        return $this->belongsTo(AsicVersion::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }

    public function moderations()
    {
        return $this->morphMany(Moderation::class, 'moderationable');
    }

    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    public function trackingUsers()
    {
        return $this->belongsToMany(User::class, 'tracks');
    }
}
