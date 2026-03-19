@extends('layouts.app')

@section('title', 'User Management')

@section('body-class', 'hold-transition sidebar-mini layout-fixed')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @php
        $showCreateErrors = old('modal_type') === 'create';
    @endphp

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
                    <h3 class="card-title mb-0">Registered Users</h3>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createUserModal">
                        <i class="fas fa-plus mr-1"></i>
                        Add User
                    </button>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at?->format('M d, Y h:i A') }}</td>
                                    <td class="text-right">
                                        <button
                                            type="button"
                                            class="btn btn-info btn-sm"
                                            data-toggle="modal"
                                            data-target="#editUserModal-{{ $user->id }}"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm"
                                            data-toggle="modal"
                                            data-target="#deleteUserModal-{{ $user->id }}"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($users->hasPages())
                    <div class="card-footer clearfix">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>

    <div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="modal_type" value="create">

                    <div class="modal-header">
                        <h5 class="modal-title">Create User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="create-name">Name</label>
                            <input
                                type="text"
                                id="create-name"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control {{ $showCreateErrors && $errors->has('name') ? 'is-invalid' : '' }}"
                                placeholder="Enter full name"
                                required
                            >
                            @if ($showCreateErrors && $errors->has('name'))
                                <span class="invalid-feedback d-block">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="create-email">Email</label>
                            <input
                                type="email"
                                id="create-email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control {{ $showCreateErrors && $errors->has('email') ? 'is-invalid' : '' }}"
                                placeholder="Enter email address"
                                required
                            >
                            @if ($showCreateErrors && $errors->has('email'))
                                <span class="invalid-feedback d-block">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="create-password">Password</label>
                            <input
                                type="password"
                                id="create-password"
                                name="password"
                                class="form-control {{ $showCreateErrors && $errors->has('password') ? 'is-invalid' : '' }}"
                                placeholder="Create a password"
                                required
                            >
                            @if ($showCreateErrors && $errors->has('password'))
                                <span class="invalid-feedback d-block">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <div class="form-group mb-0">
                            <label for="create-password-confirmation">Confirm Password</label>
                            <input
                                type="password"
                                id="create-password-confirmation"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Confirm password"
                                required
                            >
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($users as $user)
        @php
            $showEditErrors = old('modal_type') === 'edit' && (string) old('modal_user_id') === (string) $user->id;
        @endphp

        <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="modal_type" value="edit">
                        <input type="hidden" name="modal_user_id" value="{{ $user->id }}">

                        <div class="modal-header">
                            <h5 class="modal-title">Edit User #{{ $user->id }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="edit-name-{{ $user->id }}">Name</label>
                                <input
                                    type="text"
                                    id="edit-name-{{ $user->id }}"
                                    name="name"
                                    value="{{ $showEditErrors ? old('name') : $user->name }}"
                                    class="form-control {{ $showEditErrors && $errors->has('name') ? 'is-invalid' : '' }}"
                                    placeholder="Enter full name"
                                    required
                                >
                                @if ($showEditErrors && $errors->has('name'))
                                    <span class="invalid-feedback d-block">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="edit-email-{{ $user->id }}">Email</label>
                                <input
                                    type="email"
                                    id="edit-email-{{ $user->id }}"
                                    name="email"
                                    value="{{ $showEditErrors ? old('email') : $user->email }}"
                                    class="form-control {{ $showEditErrors && $errors->has('email') ? 'is-invalid' : '' }}"
                                    placeholder="Enter email address"
                                    required
                                >
                                @if ($showEditErrors && $errors->has('email'))
                                    <span class="invalid-feedback d-block">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="edit-password-{{ $user->id }}">
                                    Password
                                    <small class="text-muted">(leave blank to keep current password)</small>
                                </label>
                                <input
                                    type="password"
                                    id="edit-password-{{ $user->id }}"
                                    name="password"
                                    class="form-control {{ $showEditErrors && $errors->has('password') ? 'is-invalid' : '' }}"
                                    placeholder="Update password"
                                >
                                @if ($showEditErrors && $errors->has('password'))
                                    <span class="invalid-feedback d-block">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-0">
                                <label for="edit-password-confirmation-{{ $user->id }}">Confirm Password</label>
                                <input
                                    type="password"
                                    id="edit-password-confirmation-{{ $user->id }}"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="Confirm password"
                                >
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

        <div class="modal fade" id="deleteUserModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="modal-header">
                            <h5 class="modal-title">Delete User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            Delete <strong>{{ $user->name }}</strong> ({{ $user->email }})?
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

    <script>
        $(function () {
            var modalType = @json(old('modal_type'));
            var modalUserId = @json(old('modal_user_id'));

            if (modalType === 'create') {
                $('#createUserModal').modal('show');
            }

            if (modalType === 'edit' && modalUserId) {
                $('#editUserModal-' + modalUserId).modal('show');
            }
        });
    </script>
@endsection
