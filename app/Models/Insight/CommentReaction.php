<?php

namespace App\Models\Insight;

use Illuminate\Database\Eloquent\Model;

class CommentReaction extends Model
{
    protected $fillable = [
        'comment_id',
        'user_id',
        'type'
    ];

    public function comment()
    {
        return $this->belongsTo(\App\Models\Insight\Comment::class);
    }
}