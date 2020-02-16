<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->truncate();
        DB::table('users')->truncate();

        $adminRole = Role::where('name', 'Admin')->first();
        $tutorRole = Role::where('name', 'Tutor')->first();
        $studentRole = Role::where('name', 'Student')->first();

        $admin = User::create([
            'email' => 'captain@learnon.ca',
            'name' => 'Learnon! Admin',
            'password' => Hash::make('masterkey4'),
            'status' => 1,
            'approved' => 1
        ]);

        $tutor = User::create([
            'email' => 'tutor@learnon.ca',
            'name' => 'Learnon! Tutor',
            'password' => Hash::make('masterkey4'),
            'status' => 1,
            'approved' => 1
        ]);

        $student = User::create([
            'email' => 'student@learnon.ca',
            'name' => 'Learnon! Student',
            'password' => Hash::make('masterkey4'),
            'status' => 1,
            'approved' => 1
        ]);

        $admin->roles()->attach($adminRole);
        $tutor->roles()->attach($tutorRole);
        $student->roles()->attach($studentRole);

    }
}
