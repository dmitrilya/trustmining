<?php

namespace App\Models\Insight\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Http\Traits\WeightedSearchable;
use App\Models\Insight\ContentModel;

class Video extends ContentModel
{
    use HasFactory, WeightedSearchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'preview',
        'title',
        'url',
        'published_at',
        'moderation',
        'channel_id',
    ];

    public static array $searchWeights = [
        'title' => 10,
        'channel.name' => 5,
        'series.name' => 2,
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
