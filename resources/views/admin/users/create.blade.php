@extends('layouts.app')

@section('title', 'Create User')

@section('body-class', 'hold-transition sidebar-mini layout-fixed')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">New User Details</h3>
                </div>
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @include('admin.users._form', ['submitLabel' => 'Create User'])
                </form>
            </div>
        </div>
    </section>
@endsection
