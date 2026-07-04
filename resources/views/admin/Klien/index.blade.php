@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Data Klien')

@section('content')
<div class="container-fluid mt-3">
    <h1 class="mb-3">Data Klien</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <a href="{{ route('admin.klien.create') }}" class="btn btn-primary mb-3">+ Tambah Klien</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Perusahaan</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Email</th>
                    <th>Status Terakhir</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($klien as $k)
                <tr>
                    <td>{{ $loop->iteration + ($klien->currentPage()-1) * $klien->perPage() }}</td>
                    <td>{{ $k->nama_perusahaan }}</td>
                    <td>{{ $k->alamat }}</td>
                    <td>{{ $k->no_hp }}</td>
                    <td>{{ $k->email ?? '-' }}</td>
                    <td>
                        @if($k->riwayatStatus->count())
                            {{ ucfirst($k->riwayatStatus->first()->status) }} 
                            ({{ \Carbon\Carbon::parse($k->riwayatStatus->first()->mulai)->format('d-m-Y') }})
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $k->keterangan ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.klien.edit', $k->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-pen"></i>
                        </a>
                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapusModal{{ $k->id }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center p-3">Belum ada data klien.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-2">
        {{ $klien->links() }}
    </div>
</div>

{{-- Modal Hapus --}}
@foreach ($klien as $k)
<div class="modal fade" id="hapusModal{{ $k->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                Yakin ingin menghapus klien <strong>{{ $k->nama_perusahaan }}</strong>?
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ route('admin.klien.destroy', $k->id) }}" method="POST">
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
