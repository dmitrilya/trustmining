<?php

namespace App\Models\Blog;

use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
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
        'guide',
        'tags',
        'user_id',
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

    /**
     * Modify the query used to retrieve models when making all of the models searchable.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function makeAllSearchableUsing($query)
    {
        return $query->with(['user']);
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
            'guide' => '',
            'users.name' => ''
        ];
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }

    public function notifications()
    {
        return $this->morphMany(\App\Models\User\Notification::class, 'notificationable');
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
