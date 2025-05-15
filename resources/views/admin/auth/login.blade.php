<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Screen</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
</head>

<body>

<div class="container-fluid">
  <div class="row row-full-height">

    <!-- Left Side -->
    <div class="col-md-6 left-side flex-column text-center">
        <img src="{{ asset('admin-panel-image/WoomenSquareFlat.png') }}" alt="Logo" class="img-fluid mb-3" style="max-width: 200px;">
        <h3 class="super-admin-label">Super Admin Panel</h3>
    </div>


    <!-- Right Side -->
    <div class="col-md-6 right-side">
      <div class="brand-label">wmnzz</div> <!-- Added label here -->
      <div class="login-form">
        <h2>Login</h2>
        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="mb-3">
                <label for="mobile">Mobile Number</label>
                <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}">
                @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control">
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>

  </div>
</div>

<footer>
    &copy; {{ date('Y') }} WMNZZ. All rights reserved.
</footer>

</body>
</html>
