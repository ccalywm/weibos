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
        $data = $request->name;
        $result = Status::find($data);
        return $result;
    }

    //编辑微博
    public function update(Request $request)
    {
        $id = $request->name;
//        $updates = [];
//        if ($request->title){
//            $updates['title'] = $request->title;
//        }else if ($request->type){
//            $updates['type'] = $request['type'];
//        }else if ($request->jine){
//            $updates['jine'] = $request['jine'];
//        }else if ($request['content']){
//            $updates['content'] = $request['content'];
//        }else if ($request->time){
//            $updates['time'] = $request['time'];
//        }

        $data = Status::find($id);
        $data['title'] = $request->title;
//        $data['type'] = $request['type'];
//        $data['jine'] = $request['jine'];
        $data['content'] = $request['content'];
//        $data['time'] = $request['time'];
        $data->save();

        return $data;
    }

    //删除微博
    public function delete(Request $request)
    {
        $id = $request->name;
        $result = Status::destroy($id);
        return $result;


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
//            'jine'    => $request['jine'],
//            'time'    => $request['time'],
//            'type'    => $request['type'],
        ]);
        return $result;
    }
}
