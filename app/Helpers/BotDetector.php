<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class BotDetector
{
    /**
     * Список сигнатур ботов, парсеров, консольных утилит и мертвых движков.
     */
    protected static array $exceptAgents = [
        // Базовые роботы
        'bot',
        'finder',
        'lighthouse',
        'googleother',
        'crawler',
        'inspectiontool',
        'spider',
        'scraper',

        // Мертвые / фейковые движки и старые IE
        'presto',
        'trident/4.0',
        'trident/5.0',
        'msie 7.0',
        'msie 8.0',
        'msie 9.0',

        // Библиотеки для парсинга и скрипты
        'curl',
        'python',
        'guzzle',
        'httpclient',
        'axios',
        'wget',
        'go-http',
        'okhttp',

        // Инструменты автоматизации и тестов
        'headless',
        'postman',
        'selenium',
        'puppeteer',
        'playwright',
        'phantomjs'
    ];

    /**
     * Проверяет, является ли текущий запрос ботом.
     *
     * @param Request $request
     * @return bool True, если это бот; False, если живой пользователь.
     */
    public static function isBot(Request $request): bool
    {
        $agent = trim(strtolower($request->header('User-Agent') ?? ''));

        // 1. Проверка на пустой или слишком короткий User-Agent
        if (empty($agent) || strlen($agent) < 20) {
            return true;
        }

        // 2. Проверка по черному списку сигнатур
        foreach (self::$exceptAgents as $exceptAgent) {
            if (str_contains($agent, $exceptAgent)) {
                return true;
            }
        }

        // 3. Проверка на соответствие базовым стандартам реальных браузеров
        $isStandardBrowser = str_contains($agent, 'mozilla')
            || str_contains($agent, 'safari')
            || str_contains($agent, 'opera')
            || str_contains($agent, 'chrome');

        if (!$isStandardBrowser) {
            return true;
        }

        return false;
    }
}
