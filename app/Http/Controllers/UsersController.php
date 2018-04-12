<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserPatch;
use App\Models\Admin;

class UsersController extends Controller
{
    
    public function __construct(){
        /*
         * 使用中间件
         */
        $this->middleware('auth', [
            'except' => ['show','create', 'store','index']
        ]);
        $this->middleware("guest",["only"=>['create']]);
       
        
    }
    //全部用户
    public function index(){
        $users=User::paginate(3);
        return view("users.index",compact('users'));
    }
    //注册
    public function create(){
        return view("users.create");   
    }
    //显示用户
    public  function show(User $user){
        $this->authorize("show",$user);
        return view('users.show', compact('user'));        
        
    }
    //注册处理
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6',
            'sex'=>'required'
        ]);
        $user=User::create([
            'name'=>$request->name,
            "email"=>$request->email,
            "password"=>bcrypt($request->password),
            'sex'=>$request->sex,
        ]);
        Auth::login($user);
        session()->flash("success","欢迎，您将在这里开启一段新的旅程~");
        return redirect()->route("users.show",[$user]);
        
        
    }
    //编辑用户
    public function edit(Request $request,User $user){
        $this->authorize("update",$user);
        return view("users.edit",compact('user'));
    }
    //处理编辑用户
    /*
     * @param UpdateUserPatch $request #自己创建表单请求,验证规则写在里面
     */
    public function update(UpdateUserPatch $request,User $user){
        $this->authorize("update",$user);
        $data["name"]=$request->name;
        $data['sex']=$request->sex;
        if($request->password){
            $data['password']=bcrypt($request->password);
        }
        $user->update($data);
        session()->flash("success","个人资料更新成功！");
        return redirect()->route("users.show",$user);
    }
    public function destroy(User $user){
        
    }
    
}
