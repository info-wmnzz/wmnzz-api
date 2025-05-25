<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    @include('partials.admin-header')
    <div class="admin-container">
        @include('partials.admin-sidebar')
        
        <main class="admin-content">
            @if(session('success'))
                <div class="flash-message">
                    {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    @include('partials.admin-footer')
    <script src="{{ asset('js/alerts.js') }}"></script>
</body>
</html>
