<?php

use App\Models\Role;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => 1,
                'title' => 'Admin',
                'access_admin' => 1,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
        ];

        Role::insert($roles);
    }
}
