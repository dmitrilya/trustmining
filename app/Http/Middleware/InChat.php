<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InChat
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
        if (!$request->chat->users()->pluck('id')->contains($request->user()->id)) {
            if ($request->header('X-Requested-With') === 'XMLHttpRequest') return response()->json(['success' => false, 'message' => __('No access rights')]);
            return back()->withErrors(['forbidden' => __('No access rights')]);
        }

        return $next($request);
    }
}
