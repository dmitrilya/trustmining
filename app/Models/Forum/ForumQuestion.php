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
        'keywords',
        'forum_question_category_id',
        'user_id',
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
}
