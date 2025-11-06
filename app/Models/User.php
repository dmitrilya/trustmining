<?php

namespace App\Models;

use Laravel\Scout\Searchable;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ordering_id',
        'name',
        'url_name',
        'email',
        'balance',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('url_name', $value)->orWhere('id', $value)->first() ?? abort(404);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'name' => '',
            'url_name' => '',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function activeAds()
    {
        return $this->ads()->where('moderation', 0);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function passport()
    {
        return $this->hasOne(Passport::class);
    }

    public function hosting()
    {
        return $this->hasOne(Hosting::class);
    }

    public function offices()
    {
        return $this->hasMany(Office::class);
    }

    public function moderatedOffices()
    {
        return $this->offices()->where('moderation', false);
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function moderatedReviews()
    {
        return $this->reviews()->where('moderation', false);
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    public function trackedAds()
    {
        return $this->belongsToMany(Ad::class, 'tracks');
    }

    public function phones()
    {
        return $this->hasMany(Phone::class)->where('destroyed', false);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function crmConnections()
    {
        return $this->hasMany(CRMConnection::class);
    }
}
