<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Identified
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
        if (!$request->user()->company()->where('moderation', false)->exists() && !$request->user()->passport()->exists()) return back();

        return $next($request);
    }
}
