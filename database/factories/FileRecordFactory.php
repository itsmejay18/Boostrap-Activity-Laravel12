<?php

namespace Database\Factories;

use App\Models\FileRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FileRecord>
 */
class FileRecordFactory extends Factory
{
    protected $model = FileRecord::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'reference_code' => 'FL-' . fake()->unique()->numerify('####'),
            'category' => fake()->randomElement(['Examination', 'Scheduling', 'Registrar', 'Faculty']),
            'owner_name' => fake()->name(),
            'status' => fake()->randomElement(FileRecord::STATUSES),
            'description' => fake()->optional()->sentence(12),
        ];
    }
}
