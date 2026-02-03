<?php

namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumAnswer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'text',
        'images',
        'files',
        'forum_question_id',
        'user_id',
        'moderation'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'images' => 'array',
        'files' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }

    public function forumQuestion()
    {
        return $this->belongsTo(\App\Models\Forum\ForumQuestion::class);
    }

    public function forumComments()
    {
        return $this->hasMany(\App\Models\Forum\ForumComment::class);
    }

    public function moderatedForumComments()
    {
        return $this->hasMany(\App\Models\Forum\ForumComment::class)->where('moderation', false);
    }

    public function likes()
    {
        return $this->morphMany(\App\Models\Morph\Like::class, 'likeable');
    }

    public function moderations()
    {
        return $this->morphMany(\App\Models\Morph\Moderation::class, 'moderationable');
    }
}
