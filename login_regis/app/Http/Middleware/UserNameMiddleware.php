<?php

namespace App\Http\Middleware;

use Closure;

class UserNameMiddleware
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
        if ($request->input('email') === 'toi@gmail.com') {
            redirect('register');
        }
        return $next($request);
    }
}
