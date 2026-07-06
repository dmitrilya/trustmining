<?php

namespace App\Services\Notification\Filters;

use Carbon\Carbon;

class PriceChangeFilter implements NotificationFilterInterface
{
    public function check(array $settings, $ad): bool
    {
        $oldPrice = $ad->getPreviousPrice();

        if (is_null($oldPrice)) return false;

        $currentPrice = $ad->price * $ad->coin->rate;

        switch ($settings['condition'] ?? 'changing') {
            case 'drop':
                return $currentPrice < $oldPrice;

            case 'changing':
                return true;

            default:
                return true;
        }
    }
}
