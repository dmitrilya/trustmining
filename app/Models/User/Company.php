<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Http\Traits\Searchable;

class Company extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'card',
        'images',
        'documents',
        'description',
        'video',
        'logo',
        'bg_logo',
        'site',
        'moderation'
    ];

    public static array $searchableDependents = [
        'name' => [
            \App\Models\User\User::class => 'user',
            \App\Models\Ad\Ad::class => 'user.ads',
        ],
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'card' => 'array',
        'documents' => 'array',
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }

    public function moderations()
    {
        return $this->morphMany(\App\Models\Morph\Moderation::class, 'moderationable');
    }
}
