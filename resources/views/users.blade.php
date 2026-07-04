@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Data Pengguna')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Manajemen Pengguna</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pengguna Baru
        </a>
    </div>

    {{-- Pesan Alert Sukses --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    {{-- Main Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-users-cog mr-2"></i> Daftar Akun Pengguna</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-items-center table-hover table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Nama Lengkap</th>
                            <th>Alamat Email</th>
                            <th>Role / Jabatan</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="text-center font-weight-bold text-muted">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                <td class="font-weight-bold text-gray-800">{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @php
                                        $badgeColor = [
                                            'admin' => 'badge-primary',
                                            'manajer' => 'badge-success',
                                            'owner' => 'badge-dark',
                                            'sopir' => 'badge-info'
                                        ][$user->role] ?? 'badge-secondary';
                                    @endphp
                                    <span class="badge badge-pill {{ $badgeColor }} px-3 py-2 shadow-sm">
                                        {{ strtoupper($user->role) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning mr-2" title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @if (auth()->id() !== $user->id)
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengguna {{ $user->nama }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Data">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge badge-light text-muted" style="font-size: 0.7rem italic">Akun Anda</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <img src="{{ asset('assets/img/empty.svg') }}" alt="Empty" style="width: 150px;" class="mb-3">
                                    <p class="text-muted">Belum ada data pengguna yang terdaftar.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Footer Card untuk Pagination --}}
        @if($users->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <p class="small text-muted mb-0">
                    Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari {{ $users->total() }} pengguna
                </p>
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Styling tambahan agar serupa dengan Dashboard */
    .table thead th {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-top: none;
    }
    .badge {
        font-weight: 600;
        font-size: 0.7rem;
    }
    .btn-outline-warning:hover, .btn-outline-danger:hover {
        color: #fff !important;
    }
</style>
@endsection