<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles')->truncate();

        DB::table('roles')->insert([
            'name' => 'Admin',
            'description' => 'Administrator',
        ]);

        DB::table('roles')->insert([
            'name' => 'Tutor',
            'description' => 'Tutor',
        ]);

        DB::table('roles')->insert([
            'name' => 'Student',
            'description' => 'Student',
        ]);


    }
}
