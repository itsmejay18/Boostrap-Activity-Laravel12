@extends('layouts.app')

@section('title', 'Dashboard')

@section('body-class', 'hold-transition sidebar-mini layout-fixed')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
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

            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $totalUsers }}</h3>
                            <p>Registered Users</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="small-box-footer">Manage users <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totalFiles }}</h3>
                            <p>Total File Records</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <a href="{{ route('admin.file-management.index') }}" class="small-box-footer">Open files <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $activeFiles }}</h3>
                            <p>Active Files</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <a href="{{ route('admin.file-management.index') }}" class="small-box-footer">Review records <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $pendingFiles }}</h3>
                            <p>Pending Files</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <a href="{{ route('admin.file-management.index') }}" class="small-box-footer">Check queue <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <section class="col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Exam Days! Overview</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">
                                The Bootstrap admin panel is ready for authentication, user management, and file management.
                                Use the sidebar to switch between modules and keep the file records updated from one place.
                            </p>

                            <div class="d-flex flex-wrap">
                                <a href="{{ route('admin.file-management.index') }}" class="btn btn-primary mr-2 mb-2">
                                    <i class="fas fa-folder-open mr-1"></i>
                                    Open File Management
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary mb-2">
                                    <i class="fas fa-users mr-1"></i>
                                    Manage Users
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="col-lg-5">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Quick Notes</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">Authentication is available through the Bootstrap login page.</p>
                            <p class="mb-2">Use the File Management dropdown in the sidebar to create, update, and delete records.</p>
                            <p class="mb-0">Run <code>php artisan migrate --seed</code> to load the sample admin account and file records.</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
