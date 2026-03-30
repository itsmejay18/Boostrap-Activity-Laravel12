<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FileManagementController extends Controller
{
    public function index(): View
    {
        return view('admin.file-management.index', [
            'fileRecords' => FileRecord::query()->latest()->get(),
            'statuses' => FileRecord::STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        FileRecord::query()->create($this->validatedData($request));

        return redirect()
            ->route('admin.file-management.index')
            ->with('success', 'File record created successfully.');
    }

    public function update(Request $request, FileRecord $fileRecord): RedirectResponse
    {
        $fileRecord->update($this->validatedData($request, $fileRecord));

        return redirect()
            ->route('admin.file-management.index')
            ->with('success', 'File record updated successfully.');
    }

    public function destroy(FileRecord $fileRecord): RedirectResponse
    {
        $fileRecord->delete();

        return redirect()
            ->route('admin.file-management.index')
            ->with('success', 'File record deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?FileRecord $fileRecord = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'reference_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('file_records', 'reference_code')->ignore($fileRecord?->id),
            ],
            'category' => ['required', 'string', 'max:100'],
            'owner_name' => ['required', 'string', 'max:150'],
            'status' => ['required', 'string', Rule::in(FileRecord::STATUSES)],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);
    }
}
