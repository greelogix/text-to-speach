<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="card p-4 shadow-lg" style="width: 400px;">
        <h3 class="text-center">Login</h3>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control shadow-none @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control shadow-none @error('password') is-invalid @enderror">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>        
    <p class="text-center mt-3">Don't have an account? <a href="{{ route('register.form') }}">Register</a></p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if(session('success')) toastr.success("{{ session('success') }}"); @endif
        @if($errors->any()) toastr.error("{{ $errors->first() }}"); @endif
    </script>
</body>
</html>

   

