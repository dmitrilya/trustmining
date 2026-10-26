<?php

use App\Helpers\BotDetector;
use Illuminate\Http\Request;

if (!function_exists('is_bot_request')) {
    /**
     *
     * @param Request|null $request
     * @return bool
     */
    function is_bot_request(?Request $request = null): bool
    {
        return BotDetector::isBot($request ?? request());
    }
}

if (!function_exists('adjust_rate')) {
    /**
     * 
     * @param string|int|float $rate
     * @param string $currency
     * @return string
     */
    function adjust_rate(string|int|float $rate, string $currency = 'usdt'): string
    {
        $rate = (float) $rate;

        if ($currency == 'rub') $decimals = match (true) {
            $rate >= 10000 => 0,
            $rate >= 100   => 1,
            default       => 2,
        };
        else $decimals = match (true) {
            $rate >= 5000 => 1,
            $rate >= 40   => 2,
            $rate >= 10   => 4,
            default       => 8,
        };

        return number_format($rate, $decimals, '.', ',');
    }
}
