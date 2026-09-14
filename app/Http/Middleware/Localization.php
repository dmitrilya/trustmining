<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
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
        $supportedLocales = array_keys(config('app.supported_locales'));
        $firstSegment = $request->segment(1);

        if (in_array($firstSegment, $supportedLocales)) {
            app()->setLocale($firstSegment);
        } else {
            app()->setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
