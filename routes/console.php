<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('homepage:cache')->hourlyAt(7);
Schedule::command('ordering:update')->hourlyAt(15);
Schedule::command('subscription:check')->daily();
Schedule::command('coinprofit:update')->cron('3 2,10,18 * * *');
Schedule::command('exchangerates:update')->everyFiveMinutes();
Schedule::command('network_data:update')->everyThirtyMinutes();
Schedule::command('art:update')->twiceDaily(0, 12);
Schedule::command('sitemap:generate')->twiceDaily(1, 13);
Schedule::command('difficulty-notification:send')->twiceDaily(3, 15);
Schedule::command('trustfactors:update')->dailyAt('15:10');
Schedule::command('forumscore:update')->dailyAt('01:30');
Schedule::command('price:update')->days([1, 4])->at('10:12'); // В Laravel 13 вместо констант дней недели используются числа PHP (1 = Понедельник, 4 = Четверг)
Schedule::command('companycards:update')->dailyAt('15:00');
Schedule::command('auth:clear-resets')->daily();
Schedule::command('forum:generate')->everyMinute();
Schedule::command('publications:notify')->everyMinute();