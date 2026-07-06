<?php

namespace App\Services\Notification\Filters;

use App\Models\User\User;

interface NotificationFilterInterface
{
    /**
     * Проверяет, проходят ли условия для конкретного канала (tg, email, push...)
     */
    public function check(array $settings,  $notificationable): bool;
}
