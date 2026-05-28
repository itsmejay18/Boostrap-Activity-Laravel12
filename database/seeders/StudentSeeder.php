<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::query()->updateOrCreate([
            'firstname' => 'Juan',
            'middlename' => 'Santos',
            'lastname' => 'Dela Cruz',
        ], [
            'year' => 1,
            'course' => 'BSIT',
            'photo_url' => null,
        ]);

        Student::query()->updateOrCreate([
            'firstname' => 'Maria',
            'middlename' => 'Lopez',
            'lastname' => 'Reyes',
        ], [
            'year' => 2,
            'course' => 'BSCS',
            'photo_url' => null,
        ]);
    }
}
