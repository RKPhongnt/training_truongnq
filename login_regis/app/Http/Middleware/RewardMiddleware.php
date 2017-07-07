<?php

namespace App\Http\Middleware;

use Closure;

class RewardMiddleware
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
        echo $request->input('email');
        if ($request->input('email') === 'toi@gmail.com') {
            echo 'fail';
            return redirect('register');
        }
        echo 'true';
        return $next($request);
    }
}
