<?php
namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;
class CheckLogin{
    public function handle($request,Closure $next){
        $user=$request->user;
        if($user){
            if(Auth::user()!=$user){
                return redirect()->route("login");
            }
        }else{
            if(Auth::check()){
                return redirect()->route("users.show",[Auth::user()]);
            }
        }
        
        return $next($request);
    }
}