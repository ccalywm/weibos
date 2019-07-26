<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = factory(User::class)->times(60)->make();
        User::insert($users->makeVisible(['password','remember_token'])->toArray());

        $user = User::find(1);
        $user->name = 'ccaly';
        $user->email = 'ccalywm@cc.com';
        $user->is_admin = true;
        $user->save();

        $user2 = User::find(2);
        $user2->name = 'l';
        $user2->email = 'l@cc.com';
        $user2->is_admin = true;
        $user2->save();
    }
}
