<?php

namespace App\Models\Insight;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'brief_description',
        'description',
        'logo',
        'banner',
        'user_id',
    ];

    protected $withCount = ['activeSubscribers'];

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('slug', $value)->first() ?? abort(404);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }

    public function subscribers()
    {
        return $this->belongsToMany(\App\Models\User\User::class, 'subscriptions', 'channel_id', 'user_id');
    }

    public function activeSubscribers()
    {
        return $this->subscribers()->wherePivotNull('unsubscribed_at');
    }

    public function series()
    {
        return $this->hasMany(\App\Models\Insight\Series::class);
    }

    public function articles()
    {
        return $this->hasMany(\App\Models\Insight\Content\Article::class);
    }

    public function moderatedArticles()
    {
        return $this->articles()->where('moderation', false);
    }

    public function posts()
    {
        return $this->hasMany(\App\Models\Insight\Content\Post::class);
    }

    public function moderatedPosts()
    {
        return $this->posts()->where('moderation', false);
    }

    public function videos()
    {
        return $this->hasMany(\App\Models\Insight\Content\Video::class);
    }

    public function moderatedVideos()
    {
        return $this->videos()->where('moderation', false);
    }
}
