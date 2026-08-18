<?php

namespace App\Models\Insight;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'channel_id',
    ];

    public function channel()
    {
        return $this->belongsTo(\App\Models\Insight\Channel::class);
    }

    public function user()
    {
        return $this->hasOneThrough(\App\Models\User\User::class, \App\Models\Insight\Channel::class);
    }

    public function articles()
    {
        return $this->morphedByMany(\App\Models\Insight\Content\Article::class, 'contentable', 'series_content');
    }

    public function moderatedArticles()
    {
        return $this->articles()->where('moderation', false);
    }

    public function publishedArticles()
    {
        return $this->moderatedArticles()->where('published_at', '<=', now());
    }

    public function posts()
    {
        return $this->morphedByMany(\App\Models\Insight\Content\Post::class, 'contentable', 'series_content');
    }

    public function moderatedPosts()
    {
        return $this->posts()->where('moderation', false);
    }

    public function publishedPosts()
    {
        return $this->moderatedPosts()->where('published_at', '<=', now());
    }

    public function videos()
    {
        return $this->morphedByMany(\App\Models\Insight\Content\Video::class, 'contentable', 'series_content');
    }

    public function moderatedVideos()
    {
        return $this->videos()->where('moderation', false);
    }

    public function publishedVideos()
    {
        return $this->moderatedVideos()->where('published_at', '<=', now());
    }

    public function getAllContent()
    {
        return $this->articles->concat($this->posts)->concat($this->videos);
    }

    public function getPublishedContent()
    {
        return $this->publishedArticles->concat($this->publishedPosts)->concat($this->publishedVideos)->sortByDesc('published_at')->values();
    }
}
