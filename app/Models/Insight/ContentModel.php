<?php

namespace App\Models\Insight;

use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ReflectionClass;

abstract class ContentModel extends Model
{
    use HasFactory, Searchable;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->with = array_merge($this->with, [
            'channel' => function ($q) {
                $q->select(['id', 'name', 'logo', 'slug', 'user_id'])->withCount('activeSubscribers');
            },
            'series:id,name'
        ]);

        $this->withCount = array_merge($this->withCount, ['likes', 'views']);
    }

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

    /**
     * Автоматически находит все классы контента в папке App\Models\Insight\Content
     *
     * @return array
     */
    public static function getInheritors(): array
    {
        $inheritors = [];

        $directoryPath = app_path('Models/Insight/Content');

        if (File::isDirectory($directoryPath)) {
            $files = File::files($directoryPath);

            foreach ($files as $file) {
                $className = $file->getFilenameWithoutExtension();

                $fullClassName = "App\\Models\\Insight\\Content\\\\" . $className;

                if (class_exists($fullClassName)) {
                    $reflection = new ReflectionClass($fullClassName);

                    if ($reflection->isSubclassOf(self::class) && !$reflection->isAbstract()) {
                        $type = Str::lower($className);

                        $inheritors[$type] = $fullClassName;
                    }
                }
            }
        }

        return $inheritors;
    }

    public function scopePublished(Builder $query, $now = null): void
    {
        $query->where('moderation', false)->where('published_at', '<=', $now ?? now());
    }

    public function scopeChannelPublished(Builder $query, int $channelId, $now = null): void
    {
        $query->published($now)->where('channel_id', $channelId);
    }

    public function scopePublishedInChannels(Builder $query, array $channelIds, $now = null): void
    {
        $query->published($now)->whereIn('channel_id', $channelIds);
    }

    public function channel()
    {
        return $this->belongsTo(\App\Models\Insight\Channel::class);
    }

    public function user()
    {
        return $this->hasOneThrough(\App\Models\User\User::class, \App\Models\Insight\Channel::class, 'id', 'id', 'channel_id', 'user_id');
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
