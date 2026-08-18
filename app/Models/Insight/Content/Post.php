<?php

namespace App\Models\Insight\Content;

use Laravel\Scout\Searchable;

use App\Models\Insight\ContentModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends ContentModel
{
    use HasFactory, Searchable;

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

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime'
    ];
}
