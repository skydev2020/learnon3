<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('student_statuses')->truncate();

        DB::table('student_statuses')->insert([
            'title' => 'Need Tutoring',
            'desc' => 'Need Tutoring',
        ]);

        DB::table('student_statuses')->insert([
            'title' => 'Stop Tutoring',
            'desc' => 'Stop Tutoring',
        ]);

        DB::table('student_statuses')->insert([
            'title' => 'Change Tutor',
            'desc' => 'Change Tutor',
        ]);

        DB::table('student_statuses')->insert([
            'title' => 'Start New Tutoring',
            'desc' => 'Start New Tutoring',
        ]);
    }
}
