<!DOCTYPE html>
<html lang="en">
@include('layouts.partials.header', [
    'title' => config('app.name', 'Exam Days!') . ' | Login',
    'dashboardAssets' => false,
])
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('login') }}"><b>Exam</b> Days!</a>
    </div>
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-body">
            <p class="login-box-msg">Sign in to open the Bootstrap admin panel.</p>

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

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('process_login') }}" method="POST">
                @csrf

                <div class="input-group mb-3">
                    <input
                        type="text"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Username or Email"
                        required
                        autofocus
                    >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password"
                        required
                    >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember" value="1" @checked(old('remember'))>
                            <label for="remember">Remember Me</label>
                        </div>
                    </div>
                </div>

                <div class="social-auth-links text-center mt-2 mb-3">
                    <button type="submit" class="btn btn-block btn-primary">
                        <i class="fa fa-sign-in-alt mr-1"></i> Sign In
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('layouts.partials.footer', [
    'dashboardAssets' => false,
    'showFooter' => false,
])
</body>
</html>
