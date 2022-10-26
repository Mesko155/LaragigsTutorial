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
            return route('login'); //referira se na rutu sa imenom login
            //dodali ime na rutu za login
            //a ovu funkciju aplicirali na rutu za create job listing
            //sto znaci ako nisi loginan nemos uc
            //i onda te redirect na login named rutu
        }
    }
}
