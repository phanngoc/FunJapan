<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LocaleSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(ReligionSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(RolePermissionsSeeder::class);
        $this->call(UsersSeeder::class);
    }
}
