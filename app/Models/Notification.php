<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'notification_type_id',
        'user_id',
        'notificationable_type',
        'notificationable_id'
    ];

    public function notificationType()
    {
        return $this->belongsTo(NotificationType::class);
    }

    public function notificationable()
    {
        return $this->morphTo();
    }
}
