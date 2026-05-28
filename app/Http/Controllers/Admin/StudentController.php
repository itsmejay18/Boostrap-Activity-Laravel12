<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        return view('admin.students.index', [
            'students' => Student::query()->latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Student::query()->create($this->validatedData($request));

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student created successfully.');
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $student->update($this->validatedData($request));

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'between:1,10'],
            'course' => ['required', 'string', 'max:255'],
            'photo_url' => ['nullable', 'string'],
        ]);
    }
}
