<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CV. Dua Sahabat Prima</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            /* Background gradien modern */
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            font-family: 'Inter', 'Segoe UI', sans-serif;
            height: 100vh;
            margin: 0;
        }
        
        .login-card {
            padding: 3rem 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            background: white;
            border: none;
        }

        .logo {
            height: 85px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .brand-text {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2c3e50;
            letter-spacing: -0.5px;
        }

        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            transition: all 0.3s;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
        }

        label {
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
        }

        .btn-primary {
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            /* Tombol dengan gradien dan tanpa border */
            background: linear-gradient(to right, #0062E6, #33AEFF);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 123, 255, 0.3);
        }

        .forgot-link {
            font-size: 0.85rem;
            font-weight: 500;
            color: #0062E6;
            text-decoration: none;
            transition: color 0.3s;
        }

        .forgot-link:hover {
            color: #004bb5;
            text-decoration: underline;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="login-card text-center">
                <img src="{{ asset('assets/icons/CV.DSP.ico') }}" alt="Logo CV Dua Sahabat Prima" class="logo">
                <div class="brand-text mb-2">CV. Dua Sahabat Prima</div>

                <h5 class="mb-4 mt-3" style="font-weight: 600; color: #34495e;">Selamat Datang 👋</h5>
                <p class="text-muted mb-4" style="font-size: 0.9rem;">Silakan masukkan email dan password Anda untuk masuk.</p>

                {{-- Pesan Sukses/Status (Berguna saat reset password sukses) --}}
                @if (session('status'))
                    <div class="alert alert-success" style="font-size: 0.9rem; text-align: left;">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Pesan Error --}}
                @if($errors->any())
                    <div class="alert alert-danger" style="font-size: 0.9rem; text-align: left;">
                        <ul class="mb-0 pl-3">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group text-left">
                        <label for="email">Alamat Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
                    </div>
                    
                    <div class="form-group text-left mb-2">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>

                    <div class="form-group text-right mb-4">
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa Password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>