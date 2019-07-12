<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Message;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Mail;
//use Mail;

class UsersController extends Controller
{
    /**
     * UsersController constructor.
     * 中间件过滤，未登录的用户只能访问指定的项目
     */
    public function __construct()
    {
        $this->middleware('auth',[
            'except' => ['show','create','store','index','confirmEmail']
        ]);
        //只让未登录用户访问注册页面：
        $this->middleware('guest',[
           'only' => ['create'],
        ]);
    }
    //列出所有用户
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index',compact('users'));
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

        //Auth::login($user);
        $this->sendEmail($user);
        session()->flash('success','验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');//->route('users.show',[$user]);
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

    //删除用户
    public function destroy(User $user)
    {
        $this->authorize('destroy',$user);
        $user->delete($user->id);
        session()->flash('success','成功删除用户：'.$user->name);
        return back();
    }

    //发送激活邮件
    protected function sendEmail($user)
    {
//        $view = 'emails.confirm';
//        $data = compact('user');
//        $from = 'ccalywm@cc.com';
//        $name = 'ccaly';
//        $to = $user->email;
//        $subject = '感谢注册';
//
//        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
//            $message->from($from, $name)->to($to)->subject($subject);
//        });
        $view = 'emails.confirm';
        $data = compact('user');
        $to = $user->email;
        $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }

    //邮件激活
    public function confirmEmail($token)
    {
        $user = User::where('activation_token',$token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success','恭喜你，激活成功！');
        return redirect()->route('users.show',[$user]);
    }
}
