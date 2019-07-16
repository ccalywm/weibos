<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //允许更新的字段
    protected $fillable = ['title','jine','content','time','type',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
