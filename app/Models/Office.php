<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'images',
        'video',
        'address',
        'city',
        'peculiarities',
        'moderation',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'images' => 'array',
        'peculiarities' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function moderations()
    {
        return $this->morphMany(Moderation::class, 'moderationable');
    }

    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }
}
