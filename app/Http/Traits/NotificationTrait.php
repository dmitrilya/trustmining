<?php

namespace App\Http\Traits;

use App\Events\Notification as NotificationEvent;
use App\Jobs\SendTGNotifications;
use App\Jobs\SendTGNotifucations;

use App\Models\NotificationType;
use App\Models\Notification;

trait NotificationTrait
{
    public function notify($type, $users, $notificationableType = null, $notificationable = null)
    {
        $notifications = [];
        $typeId = NotificationType::where('name', $type)->first()->id;
        $notifId = $notificationable ? $notificationable->id : null;

        foreach ($users as $user) {
            $notifications[] = [
                'user_id' => $user->id,
                'notification_type_id' => $typeId,
                'notificationable_type' => $notificationableType,
                'notificationable_id' => $notifId,
            ];

            event(new NotificationEvent($user, $type, $notificationable));
        }
        
        Notification::upsert($notifications, ['id']);

        SendTGNotifications::dispatch($users, $type, $notificationableType, $notificationable);

        return true;
    }
}
