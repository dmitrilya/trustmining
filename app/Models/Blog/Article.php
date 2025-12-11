<?php

namespace App\Models\Blog;

use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory, Searchable;

    const UPDATED_AT = null;

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
 
    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'title' => '',
            'subtitle' => '',
            'article' => '',
        ];
    }

    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];

    public function notifications()
    {
        return $this->morphMany(\App\Models\User\Notification::class, 'notificationable');
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
