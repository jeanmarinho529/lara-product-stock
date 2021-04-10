<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user())
            if(auth()->user()->email === 'admin@admin.com')
                return $next($request);
        
        return response()->json(['mensage' => 'Unauthorized user'],401);
    }
}
