<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = new User();
        $user->name = 'UserMock';
        $user->email = 'user@mock.com';
        $user->password = bcrypt('password');
        $user->save();
    }
}

