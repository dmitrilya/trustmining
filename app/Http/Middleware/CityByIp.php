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
        if (!session()->has('useruser_location_city')) {
            try {
                $result = DaDataAddress::iplocate($request->ip(), 1);

                if ($result['data']) {
                    $city = $result['data']['city'];
                    $source = 'geo';
                    $locale = $result['data']['country_iso_code'] == 'RU' ? 'ru' : 'en';
                } else {
                    $city = config('app.default_city');
                    $source = 'default';
                    $locale = 'ru';
                }

                
                app()->setLocale($locale);

                session(['user_location' => [
                    'city' => $city,
                    'source' => $source,
                    'updated_at' => now()->timestamp,
                ], 'locale' => $locale]);
            } catch (\Exception $e) {
                session(['user_location' => [
                    'city' => config('app.default_city'),
                    'source' => 'default',
                    'updated_at' => now()->timestamp,
                ], 'locale' => 'ru']);
            }
        }

        return $next($request);
    }
}
