<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    public function create()
    {
        return view('users.create');
    }

    //显示用户界面
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    //注册表单验证
    public function store(Request $request)
    {
        //验证输入
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:3',
        ]);

        //调用方法写入数据库
        $user = User::create([
           'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        //写入完成之后返回用户页面并且提示
        session()->flash('success','欢迎注册，您将在这里开启一度新的旅程');
        return redirect()->route('users.show',[$user]);
    }
}
