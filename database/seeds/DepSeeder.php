<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'name' => 'Administration'
        ]);
        DB::table('departments')->insert([
            'name' => 'INFO'
        ]);
    }
}
