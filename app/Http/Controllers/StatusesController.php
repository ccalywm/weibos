<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusesController extends Controller
{
    //中间件过滤 登录用户才可以访问
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
           'title'   => 'required|max:140',
           'jine'    => 'required',
           'time'    => 'required',
           'content' => 'required|max:140',
        ]);

        Auth::user()->statuses()->create([
            'content' => $request['content'],
            'title'   => $request['title'],
            'jine'    => $request['jine'],
            'time'    => $request['time'],
        ]);

        session()->flash('success','发布成功！');
        return redirect()->back();
    }
}
