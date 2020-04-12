<?php

namespace App\Http\Middleware;

use Closure;

class apiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (env('API_KEY')==$request->header('apiKey')) {
            return $next($request);
        }
        return response()->json('continue tentando...');
    }
}
