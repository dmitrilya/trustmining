<?php

namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function forumSubcategories()
    {
        return $this->hasMany(\App\Models\Forum\ForumSubcategory::class);
    }

    public function forumQuestions()
    {
        return $this->hasManyThrough(\App\Models\Forum\ForumQuestion::class, \App\Models\Forum\ForumSubcategory::class);
    }

    public function publishedForumQuestions()
    {
        return $this->hasManyThrough(\App\Models\Forum\ForumQuestion::class, \App\Models\Forum\ForumSubcategory::class)
            ->where('published', true);
    }
}
