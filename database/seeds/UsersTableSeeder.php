<?php


use App\Models\User;

class UsersTableSeeder extends DatabaseSeeder
{
    public function run()
    {
        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@fashion.com';
        $user->password = 'password';
        $user->mobile = '0125' . mt_rand(1000000, 9999999);
        $user->is_active = 1;
        $user->role_id = 1;
        $user->save();


        $user = new User();
        $user->name = 'mohamed';
        $user->email = 'm.fathy@rkanjel.com';
        $user->password = 'password';
        $user->mobile = '0125' . mt_rand(1000000, 9999999);
        $user->is_active = 1;
        $user->role_id = 2;
        $user->save();

    }
}
