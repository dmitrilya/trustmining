<?php

namespace App\Services\Notification\Filters;

class ReviewEditedFilter implements NotificationFilterInterface
{
    public function check(array $settings, $review): bool
    {
        switch ($settings['c']) {
            case 'a':
                return true;
            case 'n':
                return $review->rating <= 3;
            default:
                return true;
        }
    }
}
