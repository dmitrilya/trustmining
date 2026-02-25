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

    public function articles()
    {
        return $this->morphedByMany(\App\Models\Insight\Content\Article::class, 'contentable', 'series_content');
    }

    public function moderatedArticles()
    {
        return $this->articles()->where('moderation', false);
    }

    public function posts()
    {
        return $this->morphedByMany(\App\Models\Insight\Content\Post::class, 'contentable', 'series_content');
    }

    public function moderatedPosts()
    {
        return $this->posts()->where('moderation', false);
    }

    public function videos()
    {
        return $this->morphedByMany(\App\Models\Insight\Content\Video::class, 'contentable', 'series_content');
    }

    public function moderatedVideos()
    {
        return $this->videos()->where('moderation', false);
    }

    public function getContent()
    {
        return $this->moderatedArticles->concat($this->moderatedPosts)->concat($this->moderatedVideos)->sortByDesc('created_at')->values();
    }
}
