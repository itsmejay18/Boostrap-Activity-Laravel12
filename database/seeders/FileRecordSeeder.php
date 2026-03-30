<?php

namespace Database\Seeders;

use App\Models\FileRecord;
use Illuminate\Database\Seeder;

class FileRecordSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $records = [
            [
                'reference_code' => 'FL-1001',
                'title' => 'Midterm Coverage',
                'category' => 'Examination',
                'owner_name' => 'Registrar Office',
                'status' => 'Active',
                'description' => 'Approved coverage guide for the upcoming midterm examinations.',
            ],
            [
                'reference_code' => 'FL-1002',
                'title' => 'Final Room Assignment',
                'category' => 'Scheduling',
                'owner_name' => 'Academic Affairs',
                'status' => 'Pending',
                'description' => 'Room allocation sheet prepared for final examination week.',
            ],
            [
                'reference_code' => 'FL-1003',
                'title' => 'Student Clearance Checklist',
                'category' => 'Registrar',
                'owner_name' => 'Student Services',
                'status' => 'Active',
                'description' => 'Checklist used before students can claim examination permits.',
            ],
            [
                'reference_code' => 'FL-1004',
                'title' => 'Faculty Proctoring Schedule',
                'category' => 'Faculty',
                'owner_name' => 'Department Chair',
                'status' => 'Archived',
                'description' => 'Completed assignment list of faculty proctors from the previous term.',
            ],
        ];

        foreach ($records as $record) {
            FileRecord::query()->updateOrCreate(
                ['reference_code' => $record['reference_code']],
                $record,
            );
        }
    }
}
