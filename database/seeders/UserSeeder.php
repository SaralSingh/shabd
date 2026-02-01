<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = File::get('database/json/users.json');
        $users = json_decode($jsonData);

        foreach($users as $user)
        {
            User::create(
                [
                    'name'=>$user->name,
                    'username'=>$user->username,
                    'email'=>$user->email,
                    'password'=>$user->password,
                    'role'=>$user->role
                ]
            );

        }
    }
}
