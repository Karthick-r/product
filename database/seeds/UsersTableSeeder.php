<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = "admin";
        $user->email = "admin@gmail.com";
        $user->phone = "123456";
        $user->password = bcrypt("123456");
        $user->role_id = "0";
        $user->save(); //
    }
}
