<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

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
        if (! $request->expectsJson()) {
            if($request->roles == "Super-Admin"){
                return route('admin.login');
            }
            if($request->roles == "Mangaka"){
                return route('mangaka.login');
            }
            return route('login');
        }
    }
}
