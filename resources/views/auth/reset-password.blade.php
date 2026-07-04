<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - CV. Dua Sahabat Prima</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .login-card { padding: 40px; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); background: white; margin-top: 10%; }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="col-md-5">
        <div class="login-card">
            <h5 class="text-center mb-4">Buat Password Baru 🔑</h5>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 text-left">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                {{-- Token ini wajib ada dan disembunyikan --}}
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" readonly>
                </div>
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ketik ulang password baru" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block mt-4">Simpan Password Baru</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>