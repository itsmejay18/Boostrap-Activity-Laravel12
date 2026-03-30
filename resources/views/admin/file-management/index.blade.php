@extends('layouts.app')

@section('title', 'File Management')

@section('body-class', 'hold-transition sidebar-mini layout-fixed')

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
    @php
        $showCreateErrors = old('modal_type') === 'create';
        $statusClasses = [
            'Pending' => 'warning',
            'Active' => 'success',
            'Archived' => 'secondary',
        ];
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">File Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">File Management</li>
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

            @if (session('danger'))
                <div class="alert alert-danger">
                    {{ session('danger') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Manage File Records</h3>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createFileRecordModal">
                        <i class="fas fa-plus mr-1"></i>
                        Add File Record
                    </button>
                </div>
                <div class="card-body">
                    <table id="file-records-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Reference Code</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Owner</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fileRecords as $fileRecord)
                                <tr>
                                    <td>{{ $fileRecord->id }}</td>
                                    <td>{{ $fileRecord->reference_code }}</td>
                                    <td>{{ $fileRecord->title }}</td>
                                    <td>{{ $fileRecord->category }}</td>
                                    <td>{{ $fileRecord->owner_name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $statusClasses[$fileRecord->status] ?? 'info' }}">
                                            {{ $fileRecord->status }}
                                        </span>
                                    </td>
                                    <td>{{ $fileRecord->created_at?->format('M d, Y h:i A') }}</td>
                                    <td class="text-right">
                                        <button
                                            type="button"
                                            class="btn btn-info btn-sm"
                                            data-toggle="modal"
                                            data-target="#editFileRecordModal-{{ $fileRecord->id }}"
                                        >
                                            Update
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm"
                                            data-toggle="modal"
                                            data-target="#deleteFileRecordModal-{{ $fileRecord->id }}"
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

    <div class="modal fade" id="createFileRecordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.file-management.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="modal_type" value="create">

                    <div class="modal-header">
                        <h5 class="modal-title">Create File Record</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="create-title">Title</label>
                                <input
                                    type="text"
                                    id="create-title"
                                    name="title"
                                    value="{{ old('title') }}"
                                    class="form-control {{ $showCreateErrors && $errors->has('title') ? 'is-invalid' : '' }}"
                                    placeholder="Enter file title"
                                    required
                                >
                                @if ($showCreateErrors && $errors->has('title'))
                                    <span class="invalid-feedback d-block">{{ $errors->first('title') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label for="create-reference-code">Reference Code</label>
                                <input
                                    type="text"
                                    id="create-reference-code"
                                    name="reference_code"
                                    value="{{ old('reference_code') }}"
                                    class="form-control {{ $showCreateErrors && $errors->has('reference_code') ? 'is-invalid' : '' }}"
                                    placeholder="Enter reference code"
                                    required
                                >
                                @if ($showCreateErrors && $errors->has('reference_code'))
                                    <span class="invalid-feedback d-block">{{ $errors->first('reference_code') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="create-category">Category</label>
                                <input
                                    type="text"
                                    id="create-category"
                                    name="category"
                                    value="{{ old('category') }}"
                                    class="form-control {{ $showCreateErrors && $errors->has('category') ? 'is-invalid' : '' }}"
                                    placeholder="Enter category"
                                    required
                                >
                                @if ($showCreateErrors && $errors->has('category'))
                                    <span class="invalid-feedback d-block">{{ $errors->first('category') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label for="create-owner-name">Owner</label>
                                <input
                                    type="text"
                                    id="create-owner-name"
                                    name="owner_name"
                                    value="{{ old('owner_name', auth()->user()?->name) }}"
                                    class="form-control {{ $showCreateErrors && $errors->has('owner_name') ? 'is-invalid' : '' }}"
                                    placeholder="Enter owner name"
                                    required
                                >
                                @if ($showCreateErrors && $errors->has('owner_name'))
                                    <span class="invalid-feedback d-block">{{ $errors->first('owner_name') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label for="create-status">Status</label>
                                <select
                                    id="create-status"
                                    name="status"
                                    class="form-control {{ $showCreateErrors && $errors->has('status') ? 'is-invalid' : '' }}"
                                    required
                                >
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" @selected(old('status', 'Pending') === $status)>{{ $status }}</option>
                                    @endforeach
                                </select>
                                @if ($showCreateErrors && $errors->has('status'))
                                    <span class="invalid-feedback d-block">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <label for="create-description">Description</label>
                            <textarea
                                id="create-description"
                                name="description"
                                rows="4"
                                class="form-control {{ $showCreateErrors && $errors->has('description') ? 'is-invalid' : '' }}"
                                placeholder="Enter file description"
                            >{{ old('description') }}</textarea>
                            @if ($showCreateErrors && $errors->has('description'))
                                <span class="invalid-feedback d-block">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($fileRecords as $fileRecord)
        @php
            $showEditErrors = old('modal_type') === 'edit' && (string) old('modal_file_id') === (string) $fileRecord->id;
        @endphp

        <div class="modal fade" id="editFileRecordModal-{{ $fileRecord->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.file-management.update', $fileRecord) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="modal_type" value="edit">
                        <input type="hidden" name="modal_file_id" value="{{ $fileRecord->id }}">

                        <div class="modal-header">
                            <h5 class="modal-title">Update File Record #{{ $fileRecord->id }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="edit-title-{{ $fileRecord->id }}">Title</label>
                                    <input
                                        type="text"
                                        id="edit-title-{{ $fileRecord->id }}"
                                        name="title"
                                        value="{{ $showEditErrors ? old('title') : $fileRecord->title }}"
                                        class="form-control {{ $showEditErrors && $errors->has('title') ? 'is-invalid' : '' }}"
                                        placeholder="Enter file title"
                                        required
                                    >
                                    @if ($showEditErrors && $errors->has('title'))
                                        <span class="invalid-feedback d-block">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="edit-reference-code-{{ $fileRecord->id }}">Reference Code</label>
                                    <input
                                        type="text"
                                        id="edit-reference-code-{{ $fileRecord->id }}"
                                        name="reference_code"
                                        value="{{ $showEditErrors ? old('reference_code') : $fileRecord->reference_code }}"
                                        class="form-control {{ $showEditErrors && $errors->has('reference_code') ? 'is-invalid' : '' }}"
                                        placeholder="Enter reference code"
                                        required
                                    >
                                    @if ($showEditErrors && $errors->has('reference_code'))
                                        <span class="invalid-feedback d-block">{{ $errors->first('reference_code') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="edit-category-{{ $fileRecord->id }}">Category</label>
                                    <input
                                        type="text"
                                        id="edit-category-{{ $fileRecord->id }}"
                                        name="category"
                                        value="{{ $showEditErrors ? old('category') : $fileRecord->category }}"
                                        class="form-control {{ $showEditErrors && $errors->has('category') ? 'is-invalid' : '' }}"
                                        placeholder="Enter category"
                                        required
                                    >
                                    @if ($showEditErrors && $errors->has('category'))
                                        <span class="invalid-feedback d-block">{{ $errors->first('category') }}</span>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="edit-owner-name-{{ $fileRecord->id }}">Owner</label>
                                    <input
                                        type="text"
                                        id="edit-owner-name-{{ $fileRecord->id }}"
                                        name="owner_name"
                                        value="{{ $showEditErrors ? old('owner_name') : $fileRecord->owner_name }}"
                                        class="form-control {{ $showEditErrors && $errors->has('owner_name') ? 'is-invalid' : '' }}"
                                        placeholder="Enter owner name"
                                        required
                                    >
                                    @if ($showEditErrors && $errors->has('owner_name'))
                                        <span class="invalid-feedback d-block">{{ $errors->first('owner_name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="edit-status-{{ $fileRecord->id }}">Status</label>
                                    <select
                                        id="edit-status-{{ $fileRecord->id }}"
                                        name="status"
                                        class="form-control {{ $showEditErrors && $errors->has('status') ? 'is-invalid' : '' }}"
                                        required
                                    >
                                        @foreach ($statuses as $status)
                                            <option
                                                value="{{ $status }}"
                                                @selected(($showEditErrors ? old('status') : $fileRecord->status) === $status)
                                            >
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($showEditErrors && $errors->has('status'))
                                        <span class="invalid-feedback d-block">{{ $errors->first('status') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <label for="edit-description-{{ $fileRecord->id }}">Description</label>
                                <textarea
                                    id="edit-description-{{ $fileRecord->id }}"
                                    name="description"
                                    rows="4"
                                    class="form-control {{ $showEditErrors && $errors->has('description') ? 'is-invalid' : '' }}"
                                    placeholder="Enter file description"
                                >{{ $showEditErrors ? old('description') : $fileRecord->description }}</textarea>
                                @if ($showEditErrors && $errors->has('description'))
                                    <span class="invalid-feedback d-block">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteFileRecordModal-{{ $fileRecord->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.file-management.destroy', $fileRecord) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="modal-header">
                            <h5 class="modal-title">Delete File Record</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            Delete <strong>{{ $fileRecord->title }}</strong> ({{ $fileRecord->reference_code }})?
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
            $('#file-records-table').DataTable({
                responsive: true,
                autoWidth: false,
                order: [[0, 'desc']],
                columnDefs: [
                    {
                        targets: [7],
                        orderable: false,
                        searchable: false,
                    },
                ],
            });

            var modalType = @json(old('modal_type'));
            var modalFileId = @json(old('modal_file_id'));

            if (modalType === 'create') {
                $('#createFileRecordModal').modal('show');
            }

            if (modalType === 'edit' && modalFileId) {
                $('#editFileRecordModal-' + modalFileId).modal('show');
            }
        });
    </script>
@endpush
