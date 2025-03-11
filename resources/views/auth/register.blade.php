


<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="card p-4 shadow-lg" style="width: 400px;">
        <h3 class="text-center">Register</h3>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        
        <p class="text-center mt-3">Already have an account? <a href="{{ route('login') }}">Login</a></p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if(session('success')) toastr.success("{{ session('success') }}"); @endif
        @if($errors->any()) toastr.error("{{ $errors->first() }}"); @endif
    </script>
</body>
</html>

   

