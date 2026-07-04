@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Data Truk')

@section('content')
<div class="container-fluid mt-3">
    <h1 class="mb-3">Data Truk</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <a href="{{ route('admin.mastertruk.create') }}" class="btn btn-primary mb-3">+ Tambah Truk</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Plat Nomor</th>
                    <th>Jenis Truk</th>
                    <th>Merk</th>
                    <th>Warna</th>
                    <th>Tahun</th>
                    <th>Kapasitas</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mastertruk as $truk)
                <tr>
                    <td>{{ $loop->iteration + ($mastertruk->currentPage()-1) * $mastertruk->perPage() }}</td>
                    <td>{{ $truk->plat_nomor }}</td>
                    <td>{{ $truk->jenis_truk }}</td>
                    <td>{{ $truk->merk }}</td>
                    <td>{{ $truk->warna }}</td>
                    <td>{{ $truk->tahun }}</td>
                    <td>{{ number_format($truk->kapasitas) }} kg</td>
                    <td>
                        <span class="badge 
                            @if($truk->status == 'aktif') badge-success
                            @elseif($truk->status == 'rusak') badge-danger
                            @elseif($truk->status == 'servis') badge-warning
                            @else badge-secondary @endif">
                            {{ ucfirst($truk->status) }}
                        </span>
                    </td>
                    <td>{{ $truk->keterangan ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.mastertruk.edit', $truk->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-pen"></i>
                        </a>
                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapusModal{{ $truk->id }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center p-3">Belum ada data truk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginasi --}}
    <div class="mt-2">
        {{ $mastertruk->links() }}
    </div>
</div>

{{-- Modal Hapus --}}
@foreach ($mastertruk as $truk)
<div class="modal fade" id="hapusModal{{ $truk->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                Yakin ingin menghapus truk <strong>{{ $truk->plat_nomor }}</strong>?
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ route('admin.mastertruk.destroy', $truk->id) }}" method="POST">
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
