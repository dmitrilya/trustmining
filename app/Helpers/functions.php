<?php

use App\Helpers\BotDetector;
use Illuminate\Http\Request;

if (! function_exists('is_bot_request')) {
    /**
     * Глобальный хелпер для проверки запроса на бота.
     *
     * @param Request|null $request
     * @return bool
     */
    function is_bot_request(?Request $request = null): bool
    {
        return BotDetector::isBot($request ?? request());
    }
}
