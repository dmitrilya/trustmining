<?php

namespace App\Models\Morph;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use App\Http\Traits\NotificationTrait;
use App\Models\User\User;

class Moderation extends Model
{
    use HasFactory, NotificationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'moderationable_type',
        'moderationable_id',
        'data',
        'moderation_status_id',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    protected static function booted(): void
    {
        static::created(function (Moderation $moderation) {
            $moderation->notify('New moderation', new Collection([User::whereHas('role', fn($q) => $q->where('name', 'moderator'))->first()]), 'moderation', $moderation);
        });
    }

    public function moderationable()
    {
        return $this->morphTo();
    }

    public function moderationStatus()
    {
        return $this->belongsTo(\App\Models\Morph\ModerationStatus::class);
    }

    public function notifications()
    {
        return $this->morphMany(\App\Models\User\Notification::class, 'notificationable');
    }
}
