<?php

namespace App\Services\Notification\Filters;

class NewReviewFilter implements NotificationFilterInterface
{
    public function check(array $settings, $review): bool
    {
        switch ($settings['condition']) {
            case 'all':
                return true;
            case 'negative':
                return $review->rating <= 3;
            default:
                return true;
        }
    }
}
