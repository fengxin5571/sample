<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function __construct(){
        $this->middleware("guest",['only'=>["create"]]);
    }
    //显示登录页面
    public  function create(){
       return view('sessions.create');
        
    }
    //创建新会话（登录）
    public  function store(Request $request){
        $data=$this->validate($request, [
            'email'=>'required|email|max:255',
            'password'=>'required'
        ]);
        if(Auth::attempt($data,$request->has("remember"))){
            session()->flash("success","欢迎回来");
            return redirect()->route("users.show",[Auth::user()]);
        }else{
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back();
        }
    }
    //销毁会话（退出登录）
    public  function destroy(){
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect()->route("login");
    }
    //管理员登录
    public function login(){
        return view("sessions.admin_login");
    }
    public function dologin(Request $request){
        $data=$this->validate($request, [
            'admin_email'=>'required|email|max:255',
            'admin_password'=>'required',
            
        ]);
        $data['admin_name']="fengxin";
        if(Auth::guard("admin")->attempt($data,$request->has("remember"))){
            session()->flash("success","欢迎回来");
            return redirect()->route("home");
        }else{
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back();
        }
    }
    //管理员退出
    public function admin_logout(){
        Auth::guard("admin")->logout();
        session()->flash('success', '您已成功退出！');
        return redirect()->route("admin_login");
    }
}
