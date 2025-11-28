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
        'forum_question_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }

    public function forumQuestion()
    {
        return $this->belongsTo(\App\Models\Forum\ForumQuestion::class);
    }
}
