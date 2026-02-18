<?php

namespace App\Models\Insight\Content;

use App\Models\Insight\ContentModel;
use Laravel\Scout\Searchable;

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
        'channel_id',
        'moderation',
    ];
}
