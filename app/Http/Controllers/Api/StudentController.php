<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Student::query()->latest()->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $this->validateStudent($request);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $student = Student::query()->create($validated);

        return response()->json([
            'message' => 'Student created successfully.',
            'data' => $student,
        ], 201);
    }

    public function show(Student $student): JsonResponse
    {
        return response()->json([
            'data' => $student,
        ]);
    }

    public function update(Request $request, Student $student): JsonResponse
    {
        $validated = $this->validateStudent($request);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $student->update($validated);

        return response()->json([
            'message' => 'Student updated successfully.',
            'data' => $student->fresh(),
        ]);
    }

    public function destroy(Student $student): JsonResponse
    {
        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully.',
        ]);
    }

    /**
     * @return array<string, mixed>|JsonResponse
     */
    private function validateStudent(Request $request): array|JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'between:1,10'],
            'course' => ['required', 'string', 'max:255'],
            'photo_url' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        return $validator->validated();
    }
}
