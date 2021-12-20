<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, String $roleName)
    {

        foreach ($request->user()->roles as $role) {
            // check if user role is not admin show 404 page
            if($roleName == 'Admin' && $role->name != 'Admin') {
                return abort(403);
            }
            // check if user role is not basic user show 404 page
            else if($roleName == 'Basic User' && $role->name != 'Basic User') {
                return abort(403);
            }
        }
        return $next($request);
    }
}
