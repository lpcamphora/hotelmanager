<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        /*if (! $request->expectsJson()) {
            if (isset($request->e)) {
                Cookie::queue('id-event', $request->e);                
            }
            return route('streaming.login');
        }*/
        //var_dump(Auth::check()); exit();
        return route('index.login');
    }
}
