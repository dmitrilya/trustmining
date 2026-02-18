<?php

namespace App\Models\Insight\Content;

use App\Models\Insight\ContentModel;
use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'channel_id',
        'moderation',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
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
