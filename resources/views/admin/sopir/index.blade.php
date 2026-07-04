@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Manajemen Sopir')

@section('content')
<div class="container-fluid mt-3">
    <h1 class="mb-3">Data Sopir</h1>

    {{-- Tombol Tambah --}}
    <a href="{{ route('admin.sopir.create') }}" class="btn btn-primary mb-3">+ Tambah Sopir</a>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    {{-- Tabel Sopir --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>No HP</th>
                    <th>Aktif</th>
                    <th>Plat Truk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sopirs as $sopir)
                <tr>
                    <td>{{ $loop->iteration + ($sopirs->currentPage()-1) * $sopirs->perPage() }}</td>
                    <td>{{ $sopir->user->email ?? '-' }}</td>
                    <td>{{ $sopir->nama }}</td>
                    <td>{{ $sopir->alamat }}</td>
                    <td>{{ ucfirst($sopir->status) }}</td>
                    <td>{{ $sopir->no_hp }}</td>
                    <td>{{ $sopir->aktif ? 'Ya' : 'Tidak' }}</td>
                    <td>{{ $sopir->mastertruk->plat_nomor ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.sopir.edit', $sopir->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapusModal{{ $sopir->id }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center p-3">Belum ada data sopir.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginasi --}}
    <div class="mt-2">
        {{ $sopirs->links() }}
    </div>
</div>

{{-- Modal Hapus --}}
@foreach ($sopirs as $sopir)
<div class="modal fade" id="hapusModal{{ $sopir->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                Yakin ingin menghapus sopir <strong>{{ $sopir->nama }}</strong>?
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ route('admin.sopir.destroy', $sopir->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
