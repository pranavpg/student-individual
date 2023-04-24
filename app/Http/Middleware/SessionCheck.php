<?php

namespace App\Http\Middleware;
use URL;
use Session;
use Closure;
use Request;

class SessionCheck
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
        
        if(Session::get('user_id_new')== ""){
            Session::flush();
            return redirect('/');
        }
        return $next($request);
    }
}
