<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Status;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //处理创建创建微博的请求
    public  function store(Request $request){
        $this->validate($request, [
            'content'=>"required|max:140"
        ]);
        Auth::user()->statuses()->create([
            "content"=>$request->content,
        ]);
        return redirect()->back()->with("success","微博添加成功");
    }
    //处理删除微博的请求
    public function destroy(Status $status){
        $this->authorize("delete",$status);
        $status::destroy($status->id);
        return redirect()->back()->with('success', '微博已被成功删除！');
    }
}
