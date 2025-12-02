<?php

namespace App\Models\User;

use Laravel\Scout\Searchable;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        return $this->belongsTo(\App\Models\User\Role::class);
    }

    public function ads()
    {
        return $this->hasMany(\App\Models\Ad\Ad::class);
    }

    public function activeAds()
    {
        return $this->ads()->where('moderation', 0);
    }

    public function guides()
    {
        return $this->hasMany(\App\Models\Blog\Guide::class);
    }

    public function company()
    {
        return $this->hasOne(\App\Models\User\Company::class);
    }

    public function passport()
    {
        return $this->hasOne(\App\Models\User\Passport::class);
    }

    public function hosting()
    {
        return $this->hasOne(\App\Models\Ad\Hosting::class);
    }

    public function offices()
    {
        return $this->hasMany(\App\Models\User\Office::class);
    }

    public function moderatedOffices()
    {
        return $this->offices()->where('moderation', false);
    }

    public function chats()
    {
        return $this->belongsToMany(\App\Models\Chat\Chat::class);
    }

    public function notifications()
    {
        return $this->hasMany(\App\Models\User\Notification::class);
    }

    public function reviews()
    {
        return $this->morphMany(\App\Models\Morph\Review::class, 'reviewable');
    }

    public function moderatedReviews()
    {
        return $this->reviews()->where('moderation', false);
    }

    public function tariff()
    {
        return $this->belongsTo(\App\Models\User\Tariff::class);
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\User\Order::class);
    }

    public function tracks()
    {
        return $this->hasMany(\App\Models\Ad\Track::class);
    }

    public function trackedAds()
    {
        return $this->belongsToMany(\App\Models\Ad\Ad::class, 'tracks');
    }

    public function phones()
    {
        return $this->hasMany(\App\Models\User\Phone::class)->where('destroyed', false);
    }

    public function likes()
    {
        return $this->hasMany(\App\Models\Morph\Like::class);
    }

    public function crmConnections()
    {
        return $this->hasMany(\App\Models\CRM\CRMConnection::class);
    }

    public function forumQuestions()
    {
        return $this->hasMany(\App\Models\Forum\ForumQuestion::class);
    }

    public function forumAnswers()
    {
        return $this->hasMany(\App\Models\Forum\ForumAnswer::class);
    }

    public function forumComments()
    {
        return $this->hasMany(\App\Models\Forum\ForumComment::class);
    }
}
