<?php

namespace App\Models\Insight;

use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class ContentModel extends Model
{
    use HasFactory, Searchable;

    protected $withCount = ['likes', 'views'];
    protected $with = ['series:id,name'];

    /**
     * Собирает Union-запрос из всех дочерних таблиц для связи с просмотрами.
     */
    public static function unionAllQuery()
    {
        $map = \Illuminate\Database\Eloquent\Relations\Relation::morphMap();

        $contentTypes = array_intersect_key($map, [
            'article' => '',
            'post' => '',
            'video' => '',
        ]);

        $query = null;

        foreach ($contentTypes as $alias => $class) {
            $instance = new $class;
            $sub = DB::table($instance->getTable())
                ->select('id', 'channel_id', DB::raw("'{$alias}' as type"));

            $query = is_null($query) ? $sub : $query->unionAll($sub);
        }

        return $query;
    }

    public function channel()
    {
        return $this->belongsTo(\App\Models\Insight\Channel::class);
    }

    public function series()
    {
        return $this->morphToMany(\App\Models\Insight\Series::class, 'contentable', 'series_content');
    }

    public function comments()
    {
        return $this->morphMany(\App\Models\Insight\Comment::class, 'commentable')
            ->whereNull('parent_id')->with(['user', 'replies'])->latest();
    }

    public function moderations()
    {
        return $this->morphMany(\App\Models\Morph\Moderation::class, 'moderationable');
    }

    public function views()
    {
        return $this->morphMany(\App\Models\Morph\View::class, 'viewable');
    }

    public function likes()
    {
        return $this->morphMany(\App\Models\Morph\Like::class, 'likeable');
    }
}
