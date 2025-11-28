<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function notifications()
    {
        return $this->hasMany(\App\Models\User\Notification::class);
    }
}
