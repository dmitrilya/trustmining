<?php

namespace App\Models\Insight\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Http\Traits\Searchable;
use App\Models\Insight\ContentModel;

class Article extends ContentModel
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'subtitle',
        'preview',
        'content',
        'tags',
        'published_at',
        'moderation',
        'channel_id',
    ];

    public static array $searchWeights = [
        'title' => 10,
        'subtitle' => 8,
        'channel.name' => 5,
        'series.name' => 2,
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime'
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
}
