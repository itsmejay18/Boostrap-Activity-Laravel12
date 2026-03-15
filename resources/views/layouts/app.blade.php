@php
    $pageTitle = trim($__env->yieldContent('title'));
    $bodyClass = trim($__env->yieldContent('body-class'));
@endphp
<!DOCTYPE html>
<html lang="en">
@include('layouts.partials.header', [
    'title' => $pageTitle !== '' ? $pageTitle : config('app.name', 'Laravel'),
    'dashboardAssets' => true,
])
<body class="{{ $bodyClass !== '' ? $bodyClass : 'hold-transition sidebar-mini layout-fixed' }}">
<div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="App Logo" height="60" width="60">
    </div>

    @include('layouts.partials.navbar')
    @include('layouts.partials.sidebar')

    <div class="content-wrapper">
        @yield('content')
    </div>

    @include('layouts.partials.footer', [
        'dashboardAssets' => true,
        'showFooter' => true,
    ])
</div>
</body>
</html>
