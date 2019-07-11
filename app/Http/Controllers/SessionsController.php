<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class SessionsController extends Controller
{
    /**
     * 中间件过滤 只允许未登录用户访问登录页面
     */
    public function __construct()
    {
        $this->middleware('guest',[
            'only' => ['create']
        ]);

    }

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

        if (Auth::attempt($create_user,$request->has('remember'))){
            //登陆成功
            session()->flash('success','欢迎回来');
            $fallback = route('users.show',Auth::user());
            return redirect()->intended($fallback);
//            return redirect()->route('users.show',[Auth::user()]);
        } else {
            //登陆失败
            session()->flash('danger','很抱歉，您的邮箱与密码不匹配！');
            return redirect()->back()->withInput();
        }

    }
    
    //注销登陆
    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您已成功退出！');
        return redirect('login');
    }
}
