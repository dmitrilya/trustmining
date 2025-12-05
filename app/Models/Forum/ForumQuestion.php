<?php

namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'theme',
        'text',
        'images',
        'keywords',
        'forum_question_category_id',
        'user_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'images' => 'array',
        'keywords' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }

    public function forumSubcategory()
    {
        return $this->belongsTo(\App\Models\Forum\ForumSubcategory::class);
    }

    public function forumAnswers()
    {
        return $this->hasMany(\App\Models\Forum\ForumAnswer::class);
    }

    public function moderatedForumAnswers()
    {
        return $this->hasMany(\App\Models\Forum\ForumAnswer::class)->where('moderation', false);
    }

    public function views()
    {
        return $this->morphMany(\App\Models\Morph\View::class, 'viewable');
    }
}
