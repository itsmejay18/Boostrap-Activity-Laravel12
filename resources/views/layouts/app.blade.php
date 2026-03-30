@php
    $pageTitle = trim($__env->yieldContent('title'));
    $bodyClass = trim($__env->yieldContent('body-class'));
    $dashboardAssets = trim($__env->yieldContent('dashboard-assets')) === 'true';
@endphp
<!DOCTYPE html>
<html lang="en">
@include('layouts.partials.header', [
    'title' => $pageTitle !== '' ? $pageTitle : config('app.name', 'Exam Days!'),
    'dashboardAssets' => $dashboardAssets,
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
        'dashboardAssets' => $dashboardAssets,
        'showFooter' => true,
    ])
</div>
</body>
</html>
