<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectOldAsicSlug
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
        $slug = $request->route('asicModel');

        $slugValue = $slug instanceof \Illuminate\Database\Eloquent\Model
            ? $slug->getRouteKey()
            : $slug;

        if ($slugValue && str_contains($slugValue, '_')) {
            $newSlug = str_replace('_', '-', $slugValue);

            $parameters = $request->route()->parameters();
            $parameters['asicModel'] = $newSlug;

            foreach ($parameters as $key => $value) {
                if ($value instanceof \Illuminate\Database\Eloquent\Model)
                    $parameters[$key] = $value->getRouteKey();
            }

            return redirect()->route($request->route()->getName(), $parameters, 301);
        }

        return $next($request);
    }
}
