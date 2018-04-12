<?php
namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;
class CheckLogin{
    public function handle($request,Closure $next){
        if(!Auth::guard("admin")->check()){
            return redirect()->route("admin_login");
        }
        return $next($request);
    }
}