<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $userRole)
    {
        if(strcmp(auth()->user()->role(), $userRole) == 0 || $userRole == 'dean' && auth()->user()->faculties[0]->isDean)
        {
            return $next($request);
        }
        
        return back()->with('message', 'Access denied.');
    }
}
