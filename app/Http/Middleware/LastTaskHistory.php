<?php

namespace App\Http\Middleware;
use URL;
use Session;
use Closure;
use Request;

class LastTaskHistory
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
        
        $sessionAll = Session::all();

        if(empty($sessionAll)){
             return redirect('/');
        }
        

        // $currantUrl= URL::to($_SERVER['REQUEST_URI']);
         $request1 = request()->path();
         
        if(str_contains($request1,'topic')){

             
            if(!str_contains($request1,'topic_aim')){
                Session::put('lastTask1',"");
                Session::put('lastTask1',$request1);
               
                $prefix=explode('/',$request1);
                
                Session::put('lastTaskName',"");
                //  dd($prefix);
                if(isset($prefix[1]) && !empty($prefix[1]) && isset($prefix[2]) && !empty($prefix[2])){
                    
                    $topicSession=Session::get('topics');
                    
                    $taskSession=Session::get('tasks');
                    $taskExplodeurl=array();
                    if(str_contains($prefix[2],'?n=')){
                        $taskExplodeurl=explode('?n=',$prefix[2]);
                       
                    }else{
                        $taskExplodeurl[0] = $prefix[2];
                      
                    }
                    
                    if(isset($topicSession[$prefix[1]]) && isset($taskSession[$taskExplodeurl[0]])){
                        Session::put('lastTaskName','Topic '.$topicSession[$prefix[1]]['sorting'].' / Task '.$taskSession[$taskExplodeurl[0]]['sorting']);
                    }else{
                        //Session::put('lastTaskName','Topic '.$topicSession[$prefix[1]]['sorting']);
                    }
               
                    
                }elseif(isset($prefix[1]) && !empty($prefix[1])){
                    
                    $topicSession=Session::get('topics');
                    if(isset($topicSession[$prefix[1]])){                         
                        Session::put('lastTaskName','Topic '.$topicSession[$prefix[1]]['sorting']);
                    }
                   
                } 
            }
           
          
        }
        return $next($request);
    }
}
