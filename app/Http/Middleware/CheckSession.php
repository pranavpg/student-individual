<?php

namespace App\Http\Middleware;

use Closure, Session;
use Illuminate\Http\Request;

class CheckSession
{   
    public function handle($request, Closure $next, $guard = null) 
    {
        $sessionData = Session::all();
        if(Session::get('user_id_new')== ""){
            Session::flush();
            return redirect('/');
        }
        return $next($request);
        // if(!empty($sessionData)){
        //     if(array_key_exists('user_data',$sessionData) && !empty($sessionData['user_data'])){
        //         return $next($request);    
        //     }
        // }
        // return redirect()->route('logout');
    }
}