<?php

namespace App\Models\Insight\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Http\Traits\WeightedSearchable;
use App\Models\Insight\ContentModel;

class Post extends ContentModel
{
    use HasFactory, WeightedSearchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'preview',
        'content',
        'published_at',
        'moderation',
        'channel_id',
    ];

    public static array $searchWeights = [
        'content' => 10,
        'channel.name' => 5,
        'series.name' => 2,
    ];

    public static array $searchSettings = [
        'content' => [
            'strip_tags' => true,
            'limit' => 70,
        ],
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime'
    ];
}
