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
            if(Auth::user()->activated){
                session()->flash("success","欢迎回来");
                session()->put("login_ip", [Auth::user()->id=>$request->getClientIp()]);
                return redirect()->intended(route("users.show",[Auth::user()]));
            }else{
                $token=Auth::user()->activation_token;
                Auth::logout();
                session()->flash('warning', "你的账号未激活，请检查邮箱中的注册邮件进行激活。".$token);
                return redirect("/");
            }
            
        }else{
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back();
        }
    }
    //销毁会话（退出登录）
    public  function destroy(){
        Auth::logout();
        session()->forget("logig_ip");
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
            
        ],[
            "admin_email.required"=>":attribute 不能为空",
            "admin_password"=>":attribute 不能为空"
        ],[
            "admin_email"=>'管理员邮箱',
            "admin_password"=>"管理员密码"
        ]);
        if(Auth::guard("admin")->attempt($data,$request->has("remember"))){
            session()->flash("success","欢迎回来");
            return redirect()->intended(route("admins.show",Auth::guard("admin")->user()));
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
