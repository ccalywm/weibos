<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Status;

class StatusPolicy
{
    use HandlesAuthorization;

    //授权策略 如果当前用户的id与要删除的微博作者id相同是验证通过
    public function destroy(User $user, Status $status)
    {
        return $user->id === $status->user_id;
    }


    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
