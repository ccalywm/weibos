<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class SessionsController extends Controller
{
    //返回登陆页面
    public function create()
    {
        return view('sessions.create');
    }
    
    //验证登陆表单
    public function store(Request $request)
    {
        $create_user = $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' => 'required|',
        ]);

        if (Auth::attempt($create_user)){
            //登陆成功
            session()->flash('sussess','欢迎回来');
            return redirect()->route('users.show',[Auth::user()]);
        } else {
            //登陆失败
            session()->flash('danger','很抱歉，您的邮箱与密码不匹配！');
            return redirect()->back()->withInput();
        }

    }
}
