<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            'department_id' => 1,
            'name' => 'Admin'
        ]);
        DB::table('groups')->insert([
            'department_id' => 2,
            'name' => 'DSI5.1'
        ]);
        DB::table('groups')->insert([
            'department_id' => 2,
            'name' => 'MDW5.1'
        ]);
        DB::table('groups')->insert([
            'department_id' => 2,
            'name' => 'RSI5.1'
        ]);
    }
}
