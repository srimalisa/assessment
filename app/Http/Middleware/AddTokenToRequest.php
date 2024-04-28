<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AddTokenToRequest
{

    protected $except = [
        '/',
        '*/login',
        'register',
        'password/reset',
        'user/restaurant'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->get('token');
        $isTokenNull = (empty(trim($token)) || strtolower($token) === 'null');
        foreach ($this->except as $path) {
            if ($request->is($path) && $isTokenNull) {
                return $next($request);
            }
        }

        if($isTokenNull) {
            return response()->view('errors.401', [], 401);
        }
        $user = User::where('api_token', $token)->first();
        if(!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        Auth::setUser($user);
        return $next($request);
    }
}
