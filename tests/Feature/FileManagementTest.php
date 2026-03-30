<?php

use App\Models\FileRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated users can view the file management page', function () {
    $admin = User::factory()->create();
    $fileRecord = FileRecord::factory()->create([
        'title' => 'Exam Permit',
        'reference_code' => 'FL-9001',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.file-management.index'))
        ->assertOk()
        ->assertSee('File Management')
        ->assertSee($fileRecord->title)
        ->assertSee($fileRecord->reference_code);
});

test('authenticated users can create a file record', function () {
    $admin = User::factory()->create();

    $this->actingAs($admin)
        ->post(route('admin.file-management.store'), [
            'title' => 'Student Permit List',
            'reference_code' => 'FL-2001',
            'category' => 'Registrar',
            'owner_name' => 'Records Unit',
            'status' => 'Pending',
            'description' => 'Generated list of permits for the examination week.',
        ])
        ->assertRedirect(route('admin.file-management.index'));

    $this->assertDatabaseHas('file_records', [
        'title' => 'Student Permit List',
        'reference_code' => 'FL-2001',
        'category' => 'Registrar',
        'owner_name' => 'Records Unit',
        'status' => 'Pending',
    ]);
});

test('authenticated users can update a file record', function () {
    $admin = User::factory()->create();
    $fileRecord = FileRecord::factory()->create([
        'reference_code' => 'FL-2002',
        'status' => 'Pending',
    ]);

    $this->actingAs($admin)
        ->put(route('admin.file-management.update', $fileRecord), [
            'title' => 'Updated File Record',
            'reference_code' => 'FL-2002',
            'category' => 'Examination',
            'owner_name' => 'Registrar Office',
            'status' => 'Active',
            'description' => 'Updated during automated feature testing.',
        ])
        ->assertRedirect(route('admin.file-management.index'));

    $this->assertDatabaseHas('file_records', [
        'id' => $fileRecord->id,
        'title' => 'Updated File Record',
        'status' => 'Active',
    ]);
});

test('authenticated users can delete a file record', function () {
    $admin = User::factory()->create();
    $fileRecord = FileRecord::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.file-management.destroy', $fileRecord))
        ->assertRedirect(route('admin.file-management.index'));

    $this->assertDatabaseMissing('file_records', [
        'id' => $fileRecord->id,
    ]);
});
