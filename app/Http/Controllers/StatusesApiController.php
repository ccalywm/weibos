<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class StatusesApiController extends Controller
{
    //获取微博个人所有微博
    public function index(Request $request)
    {
       $statuses = $request->user()->statuses()
           ->orderBy('created_at','desc')
           ->get();
//        ->paginate(10);
       return $statuses;
    }
    
    //获取单条微博
    public function show(Request $request)
    {
        return $request;
    }
    //发布微博
    public function store(Request $request)
    {
        /**
         * 尚未验证输入 很危险
         */

        $result = $request->user()->statuses()->create([
            'content' => $request['content'],
            'title'   => $request['title'],
            'jine'    => $request['jine'],
            'time'    => $request['time'],
            'type'    => $request['type'],
        ]);
        return $result;
    }
}
