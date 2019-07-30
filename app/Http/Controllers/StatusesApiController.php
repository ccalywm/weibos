<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class StatusesApiController extends Controller
{
    //发布微博
    public function store(Request $request)
    {
        $data = $request->user();



        $result = $request->user()->statuses()->create([
            'content' => $request['content'],
            'title'   => $request['title'],
            'jine'    => $request['jine'],
            'time'    => $request['time'],
            'type'    => $request['type'],
        ]);
        return $data.$result;
    }
}
