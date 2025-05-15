<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @include('partials.admin-header')
    <div class="admin-container">
        @include('partials.admin-sidebar')

        <main class="admin-content">
            @yield('content')
        </main>
    </div>
    @include('partials.admin-footer')
</body>
</html>
