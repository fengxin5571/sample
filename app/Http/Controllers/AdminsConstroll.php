<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Rules\AdminDifferent;
use App\Models\User;

class AdminsConstroll extends Controller
{
    //显示管理员
    public function admin_show(Admin $admin){
        return view("admins.show",compact("admin"));
    }
    //编辑管理员界面
    public function admin_edit(Request $request,Admin $admin){
        
        if($request->isMethod("POST")){
            $this->validate($request, [
                'admin_name'=>"required|max:50",
                'admin_password'=>'nullable|confirmed|min:6|different:admin_password',
            ]);
            $data['admin_name']=$request->admin_name;
            if($request->admin_password){
                $data['admin_password']=bcrypt($request->admin_password);
            }
            $admin->update($data);
            return redirect()->route("admins.show",$admin)->with("success","管理员资料更新成功");
        }
        return view("admins.edit",compact('admin'));
    }
    //删除用户
    public function destroy(Admin $admin,User $user){
        $user->delete();
        return redirect()->route("users.index")->with("success","删除用户成功");
        
    }
}
