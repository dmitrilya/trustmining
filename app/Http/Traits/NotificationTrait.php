<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Events\Notification as NotificationEvent;
use App\Jobs\SendEmailNotifications;
use App\Jobs\SendTGNotifications;
use App\Jobs\SendWebNotifications;
use App\Models\User\NotificationType;
use App\Models\User\Notification;

trait NotificationTrait
{
    public function notify(string $type, Collection $users, $notificationableType = null, $notificationable = null)
    {
        $users->loadMissing('settings');
        $typeId = NotificationType::where('name', $type)->first('id')->id;

        if ($notificationableType != 'message') {
            $notifications = [];
            $notifId = $notificationable ? $notificationable->id : null;
            $users = $users->unique();

            foreach ($users as $user) {
                $notifications[] = [
                    'user_id' => $user->id,
                    'notification_type_id' => $typeId,
                    'notificationable_type' => $notificationableType,
                    'notificationable_id' => $notifId,
                ];

                // TODO event(new NotificationEvent($user, $type, $notificationable)); для пушера (Channels)
            }

            Notification::upsert($notifications, ['id']);
        }

        $filters = [
            'New message' => \App\Services\Notification\Filters\NewMessageFilter::class,
            'New review'  => \App\Services\Notification\Filters\NewReviewFilter::class,
            'Review edited' => \App\Services\Notification\Filters\ReviewEditedFilter::class,
            'Price change' => \App\Services\Notification\Filters\PriceChangeFilter::class,
            'Difficulty changing' => \App\Services\Notification\Filters\DifficultyChangingFilter::class,
        ];

        $filterClass = $filters[$type] ?? null;
        $filterInstance = $filterClass ? app($filterClass) : null;

        $tgIds = $users->filter(function ($user) use ($typeId, $filterInstance, $notificationable) {
            if (!$user->tg_id || $user->tg_id == 0) return false;

            $isEnabled = data_get($user->settings->notifications, "{$typeId}.t.on");
            $allowedByConfig = is_null($isEnabled) ? true : (bool) $isEnabled;

            if (!$allowedByConfig) return false;

            return $filterInstance ? $filterInstance->check($user->settings->notifications[$typeId]['t'], $notificationable) : true;
        })->pluck('tg_id')->unique();

        if ($tgIds->isNotEmpty()) SendTGNotifications::dispatch($tgIds, $type, $notificationableType, $notificationable);

        $webUserIds = $users->filter(function ($user) use ($typeId, $filterInstance, $notificationable) {
            $isEnabled = data_get($user->settings->notifications, "{$typeId}.w.on");
            $allowedByConfig = is_null($isEnabled) ? true : (bool) $isEnabled;

            if (!$allowedByConfig) return false;

            return $filterInstance ? $filterInstance->check($user->settings->notifications[$typeId]['w'], $notificationable) : true;
        })->pluck('id')->unique();

        if ($webUserIds->isNotEmpty()) SendWebNotifications::dispatch($webUserIds, $type, $notificationableType, $notificationable);

        $emailUsers = $users->filter(function ($user) use ($typeId, $filterInstance, $notificationable) {
            if (!$user->email) return false;

            $isEnabled = data_get($user->settings->notifications, "{$typeId}.e.on");
            $allowedByConfig = is_null($isEnabled) ? true : (bool) $isEnabled;

            if (!$allowedByConfig) return false;

            return $filterInstance ? $filterInstance->check($user->settings->notifications[$typeId]['e'], $notificationable) : true;
        })->pluck('tg_id');

        if ($emailUsers->isNotEmpty()) SendEmailNotifications::dispatch($emailUsers, $type, $notificationableType, $notificationable);

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
