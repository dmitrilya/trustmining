<?php

namespace App\Models;

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
        return $this->where('url_title', $value)->first() ?? abort(404);
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
            'url_title' => '',
            'subtitle' => '',
            'article' => '',
        ];
    }

    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notificationable');
    }
}
