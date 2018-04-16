<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserPatch;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    
    public function __construct(){
        /*
         * 使用中间件
         */
        $this->middleware('auth', [
            'except' => ['show','create', 'store','index','confirmEmail']
        ]);
        $this->middleware("guest",["only"=>['create']]);
       
        
    }
    //全部用户
    public function index(){
        $users=User::paginate(1);
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
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');

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
    /*
     * 发送邮件事件
     */
    protected function sendEmailConfirmationTo($user){
        $view = 'emails.confirm';
        $data = compact('user');
        $to = $user->email;
        $subject = "感谢注册 Sample 应用！请确认你的邮箱。";
        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
        
    }
    /*激活邮件事件*/
    public function confirmEmail($token){
        $user=User::where("activation_token",$token)->firstOrFail();
        $user->activated=1;
        $user->activation_token=null;
        $user->save();
        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }
}
