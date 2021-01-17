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
            'group_id' => 1,
            'name' => "qsd",
            'email' => "qsd@qsd.qsd",
            'password' => Hash::make('qsdqsdqsd'),
            'role' => 0
        ]);

        DB::table('users')->insert([
            'name' => "qsd",
            'email' => "qsdqsd@qsd.qsd",
            'password' => Hash::make('qsdqsdqsd'),
            'role' => 1
        ]);

        DB::table('users')->insert([
            'name' => "qsd",
            'email' => "qsdqsdqsd@qsd.qsd",
            'password' => Hash::make('qsdqsdqsd'),
            'role' => 2
        ]);
    }
}
