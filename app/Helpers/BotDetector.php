<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class BotDetector
{
    protected static array $exceptAgents = [
        // Роботы автоматизации, которые умеют исполнять JS (Puppeteer, Selenium и др.)
        'headless',
        'selenium',
        'puppeteer',
        'playwright',
        'phantomjs',

        // Инструменты ручного тестирования API (если кто-то штурмует ваш API напрямую)
        'postman',
        'insomnia',

        // Официальные тяжелые краулеры (на случай, если они начнут исполнять JS на странице)
        'bot',
        'finder',
        'lighthouse',
        'googleother',
        'crawler',
        'inspectiontool',
        'spider',
        'scraper',
        'search',
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

        // Защита от пустых заголовков при прямых запросах к API
        if (empty($agent)) {
            return true;
        }

        // Проверка по лаконичному черному списку
        foreach (self::$exceptAgents as $exceptAgent) {
            if (str_contains($agent, $exceptAgent)) {
                return true;
            }
        }

        return false;
    }
}
