<?php

namespace App\Http\Traits;

use App\Events\Notification as NotificationEvent;

use App\Models\NotificationType;
use App\Models\Notification;

trait NotificationTrait
{
    public function notify($type, $user, $notificationableType, $notificationable)
    {
        Notification::create([
            'user_id' => $user->id,
            'notification_type_id' => NotificationType::where('name', $type)->first()->id,
            'notificationable_type' => $notificationableType,
            'notificationable_id' => $notificationable->id,
        ]);

        event(new NotificationEvent($user, $type, $notificationable));

        return true;
    }
}
