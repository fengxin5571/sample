<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    
    //注册
    public function create(){
       
        return view("users.create");   
    }
    //显示用户
    public  function show(User $user){
        if(Auth::check()&&Auth::user()==$user){
            return view('users.show', compact('user'));
        }else{
            return redirect("login");
        }
        
    }
    //注册处理
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        $user=User::create([
            'name'=>$request->name,
            "email"=>$request->email,
            "password"=>bcrypt($request->password)
        ]);
        Auth::login($user);
        session()->flash("success","欢迎，您将在这里开启一段新的旅程~");
        return redirect()->route("users.show",[$user]);
    }
}
