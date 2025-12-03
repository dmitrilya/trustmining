<?php

namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('name', str_replace('_', ' ', $value))->first() ?? abort(404);
    }

    public function forumSubcategories()
    {
        return $this->hasMany(\App\Models\Forum\ForumSubcategory::class);
    }

    public function forumQuestions()
    {
        return $this->hasManyThrough(\App\Models\Forum\ForumQuestion::class, \App\Models\Forum\ForumSubcategory::class);
    }

    public function moderatedForumQuestions()
    {
        return $this->hasManyThrough(\App\Models\Forum\ForumQuestion::class, \App\Models\Forum\ForumSubcategory::class)
            ->where('moderation', false);
    }
}
