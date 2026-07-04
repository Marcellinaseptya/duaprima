<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dashboard')</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  {{-- <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}"> --}}

  <style>
    /* Hapus opacity 0 yang membuat konten hilang/pecah */
    .content-wrapper {
      background-color: #f4f6f9;
      padding: 20px;
    }
    .bg-darkblue { background-color: #001f3f !important; }
    
    /* Pastikan Sidebar terlihat */
    .main-sidebar { min-height: 100vh !important; }
  </style>

  @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link bg-darkblue">
      <span class="brand-text font-weight-light">CV. DUA SAHABAT PRIMA</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          
        {{-- LOGIKA SIDEBAR BERDASARKAN ROLE (JABATAN) --}}
@if(Auth::user()->role == 'admin')
    @include('partials.sidebar-admin')
@elseif(Auth::user()->role == 'manajer')
    @include('partials.sidebar-manajer')
@elseif(Auth::user()->role == 'sopir')
    @include('partials.sidebar-sopir')
@elseif(Auth::user()->role == 'owner')
    @include('partials.sidebar-owner')
@else
    {{-- Cadangan jika role tidak terdefinisi --}}
    @include('partials.sidebar-admin')
@endif
        </ul>
      </nav>
    </div>
  </aside>

  <nav class="main-header navbar navbar-expand navbar-dark bg-darkblue border-bottom-0">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-danger btn-sm px-3">
            <i class="fas fa-sign-out-alt"></i> Logout
          </button>
        </form>
      </li>
    </ul>
  </nav>

  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>
  </div>

  <footer class="main-footer text-sm text-center">
      <strong>&copy; {{ date('Y') }} CV. Dua Sahabat Prima</strong>
  </footer>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')
</body>
</html>