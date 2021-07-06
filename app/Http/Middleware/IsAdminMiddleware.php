<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   
        // if is_admin is 1 in users table this middleware will protect the route.
        //app\Models\User.php - is admin in this file as atttribute it is defined.
        if(!auth()->user()->is_admin){ 
            abort(403);
        }
        return $next($request);
    }
}
