<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use MoveMoveIo\DaData\Facades\DaDataAddress;

class CityByIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user_city')) {
            try {
                $result = DaDataAddress::iplocate($request->ip(), 1);

                $city = $result['data']['city'] ?? config('app.default_city');

                $locale = $result['data']['country_iso_code'] == 'RU' ? 'ru' : 'en';
                app()->setLocale($locale);

                session(['user_city' => $city, 'locale' => $locale]);
            } catch (\Exception $e) {
                session(['user_city' => config('app.default_city'), 'locale' => 'ru']);
            }
        }

        return $next($request);
    }
}
