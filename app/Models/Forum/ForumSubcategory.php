<?php

namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumSubcategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function forumCategory()
    {
        return $this->belongsTo(\App\Models\Forum\ForumCategory::class);
    }

    public function forumQuestions()
    {
        return $this->hasMany(\App\Models\Forum\ForumQuestion::class);
    }

    public function moderatedForumQuestions()
    {
        return $this->hasMany(\App\Models\Forum\ForumQuestion::class)->where('moderation', false);
    }
}
