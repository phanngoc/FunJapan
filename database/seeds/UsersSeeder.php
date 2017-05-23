<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@funjapan.jp',
                'password' => '123456',
                'role_id' => 1,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
