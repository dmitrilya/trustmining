<?php

namespace App\Models\Insight;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'text',
        'parent_id'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }

    public function parent()
    {
        return $this->belongsTo(\App\Models\Insight\Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(\App\Models\Insight\Comment::class, 'parent_id')->with('user')->latest();
    }

    public function reactions()
    {
        return $this->hasMany(\App\Models\Insight\CommentReaction::class);
    }
}
