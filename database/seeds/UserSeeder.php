<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'group_id' => 2,
            'name' => "Med Chouiref",
            'email' => "med@qsd.qsd",
            'password' => Hash::make('qsdqsdqsd'),
            'role' => 0
        ]);
        DB::table('users')->insert([
            'group_id' => 2,
            'name' => "Zied Gmar",
            'email' => "zied@qsd.qsd",
            'password' => Hash::make('qsdqsdqsd'),
            'role' => 0
        ]);
        DB::table('users')->insert([
            'group_id' => 2,
            'name' => "Lassad salem",
            'email' => "lsd@qsd.qsd",
            'password' => Hash::make('qsdqsdqsd'),
            'role' => 0
        ]);

        DB::table('users')->insert([
            'group_id' => 1,
            'name' => "Nahla Sessi",
            'email' => "Nahla@qsd.qsd",
            'password' => Hash::make('qsdqsdqsd'),
            'role' => 1
        ]);

        DB::table('users')->insert([
            'group_id' => 1,
            'name' => "Administration",
            'email' => "admin@qsd.qsd",
            'password' => Hash::make('qsdqsdqsd'),
            'role' => 2
        ]);
    }
}
