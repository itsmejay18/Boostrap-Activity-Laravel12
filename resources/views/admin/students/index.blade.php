@extends('layouts.app')

@section('title', 'Students')

@section('body-class', 'hold-transition sidebar-mini layout-fixed')

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
    @php
        $showCreateErrors = old('modal_type') === 'create';
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Students</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Students</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Student Records</h3>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createStudentModal">
                        <i class="fas fa-plus mr-1"></i>
                        Add Student
                    </button>
                </div>
                <div class="card-body">
                    <table id="students-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Year</th>
                                <th>Course</th>
                                <th>Photo URL</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td><small>{{ $student->id }}</small></td>
                                    <td>{{ $student->firstname }}</td>
                                    <td>{{ $student->middlename ?? '-' }}</td>
                                    <td>{{ $student->lastname }}</td>
                                    <td>{{ $student->year }}</td>
                                    <td>{{ $student->course }}</td>
                                    <td>
                                        @if ($student->photo_url)
                                            <a href="{{ $student->photo_url }}" target="_blank" rel="noopener">View Photo</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <button
                                            type="button"
                                            class="btn btn-info btn-sm"
                                            data-toggle="modal"
                                            data-target="#editStudentModal-{{ $student->id }}"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm"
                                            data-toggle="modal"
                                            data-target="#deleteStudentModal-{{ $student->id }}"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="createStudentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.students.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="modal_type" value="create">

                    <div class="modal-header">
                        <h5 class="modal-title">Create Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        @include('admin.students.partials.form', [
                            'prefix' => 'create',
                            'student' => null,
                            'showErrors' => $showCreateErrors,
                        ])
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($students as $student)
        @php
            $showEditErrors = old('modal_type') === 'edit' && old('modal_student_id') === $student->id;
        @endphp

        <div class="modal fade" id="editStudentModal-{{ $student->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.students.update', $student) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="modal_type" value="edit">
                        <input type="hidden" name="modal_student_id" value="{{ $student->id }}">

                        <div class="modal-header">
                            <h5 class="modal-title">Edit Student</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            @include('admin.students.partials.form', [
                                'prefix' => 'edit-' . $student->id,
                                'student' => $student,
                                'showErrors' => $showEditErrors,
                            ])
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteStudentModal-{{ $student->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="modal-header">
                            <h5 class="modal-title">Delete Student</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            Delete <strong>{{ $student->firstname }} {{ $student->lastname }}</strong>?
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function () {
            $('#students-table').DataTable({
                responsive: true,
                autoWidth: false,
                columnDefs: [
                    {
                        targets: [7],
                        orderable: false,
                        searchable: false,
                    },
                ],
            });

            var modalType = @json(old('modal_type'));
            var modalStudentId = @json(old('modal_student_id'));

            if (modalType === 'create') {
                $('#createStudentModal').modal('show');
            }

            if (modalType === 'edit' && modalStudentId) {
                $('#editStudentModal-' + modalStudentId).modal('show');
            }
        });
    </script>
@endpush
