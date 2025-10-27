<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\View\View;

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

        if ($users->whereNotNull('tg_id')->where('tg_id', '!=', 0)->count())
            SendTGNotifications::dispatch($users, $type, $notificationableType, $notificationable);

        return true;
    }

    public function notifications(Request $request): View
    {
        $notifications = $request->user()->notifications()->with(['notificationType', 'notificationable']);

        if ($request->notificationable_types && count($request->notificationable_types))
            $notifications = $notifications->whereIn('notificationable_type', $request->notificationable_types);

        return view('notification.index', [
            'notifications' => $notifications->latest()->paginate(50)
        ]);
    }

    public function notificationsCheck(Request $request)
    {
        $request->user()->notifications()->update(['checked' => true]);

        return response()->json(['success' => true], 200);
    }
}
