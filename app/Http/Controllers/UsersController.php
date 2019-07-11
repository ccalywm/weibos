<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;
class UsersController extends Controller
{
    /**
     * UsersController constructor.
     * 中间件过滤，未登录的用户只能访问指定的项目
     */
    public function __construct()
    {
        $this->middleware('auth',[
            'except' => ['show','create','store']
        ]);
        //只让未登录用户访问注册页面：
        $this->middleware('guest',[
           'only' => ['create'],
        ]);
    }

    //注册用户
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
        Auth::login($user);
        session()->flash('success','欢迎注册，您将在这里开启一度新的旅程');
        return redirect()->route('users.show',[$user]);
    }

    //编辑用户资料界面
    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }
    //更新用户资料
    public function update(Request $request,User $user)
    {
        $this->authorize('update',$user);
        //验证输入
        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:3',
        ]);
        $data = [];
        $data['name'] = $request->name;
        if ($request->password){
            $data['password'] = bcrypt($request->password);
        }

        //调用update方法进行更新
        $user->update($data);

        //更新完成之后返回用户主页
        session()->flash('success','修改成功，若修改了密码则下次登录时生效！');
        return redirect()->route('users.show',$user->id);
    }
}
