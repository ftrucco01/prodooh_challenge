<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = new User();
        $user->name = 'Image Creator';
        $user->email = 'creator@mock.com';
        $user->password = bcrypt('password');
        $user->role = 'image_generator';
        $user->save();

        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@mock.com';
        $user->password = bcrypt('password');
        $user->role = 'admin';
        $user->save();
    }
}

