<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class roleUrlPrefix
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
        $user = Auth::user();
        $adminRoles = ['Super Administrator', 'Administrator'];

        if(!empty(array_intersect($user->role, $adminRoles))) {
            $request->route()->setPrefix('admin');
        } else {
            $request->route()->setPrefix('user');
        }
        return $next($request);
    }
}
