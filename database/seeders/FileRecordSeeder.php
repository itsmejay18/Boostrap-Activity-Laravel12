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
         
        
        ];

        foreach ($records as $record) {
            FileRecord::query()->updateOrCreate(
                ['reference_code' => $record['reference_code']],
                $record,
            );
        }
    }
}
