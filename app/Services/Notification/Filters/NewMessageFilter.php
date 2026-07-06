<?php

namespace App\Services\Notification\Filters;

class NewMessageFilter implements NotificationFilterInterface
{
    public function check(array $settings, $message): bool
    {
        switch ($settings['frequency']) {
            case 'all':
                return true;
            case 'first':
                $messageDate = $message->created_at;

                return $message->chat->messages()
                    ->where('id', '!=', $message->id)
                    ->whereBetween('created_at', [
                        $messageDate->copy()->startOfDay(),
                        $messageDate->copy()->endOfDay()
                    ])
                    ->exists();
            default:
                return true;
        }
    }
}
