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
        $supportedLocales = ['en'];
        $firstSegment = $request->segment(1);

        if (in_array($firstSegment, $supportedLocales)) {
            app()->setLocale($firstSegment);
        } else {
            app()->setLocale('ru');
        }

        return $next($request);
    }
}
