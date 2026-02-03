<?php

namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Morph\Like;

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
        'files',
        'keywords',
        'similar_questions',
        'forum_question_category_id',
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
        'keywords' => 'array',
        'similar_questions' => 'array',
    ];

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->find(explode('-', $value)[0]) ?? abort(404);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }

    public function getSimilarQuestionsListAttribute()
    {
        return self::whereIn('id', $this->similar_questions)->where('published', true)
            ->select(['id', 'forum_subcategory_id', 'theme', 'created_at'])
            ->with(['forumSubcategory:id,name,forum_category_id', 'forumSubcategory.forumCategory:id,name'])
            ->withCount('moderatedForumAnswers')->withCount('views')->get();
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
        return $this->forumAnswers()->where('moderation', false);
    }

    public function views()
    {
        return $this->morphMany(\App\Models\Morph\View::class, 'viewable');
    }

    public function moderations()
    {
        return $this->morphMany(\App\Models\Morph\Moderation::class, 'moderationable');
    }
}
