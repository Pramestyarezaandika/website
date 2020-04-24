<?php

namespace App\Http\Middleware;

use Closure,Session,Schema;

class AuthFirebase
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
        $firebaseSession = Session::get('token');

        if (empty($firebaseSession)) {
            return redirect('login');
        }

        return $next($request);
    }
}
