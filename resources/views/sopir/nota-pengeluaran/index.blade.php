@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Riwayat Nota Pengeluaran')

@section('content')

<div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h1 class="m-0">Riwayat Nota Pengeluaran</h1>
        <a href="{{ route('sopir.nota-pengeluaran.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Tambah Nota
        </a>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Nota Pengeluaran</h3>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover text-nowrap">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Nota</th>
                            <th>Keterangan</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notas as $nota)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($nota->tanggal)->format('d M Y') }}</td>
                            <td>{{ ucfirst($nota->jenis) }}</td>
                            <td>{{ $nota->keterangan ?? '-' }}</td>
                            <td>
                                @php $ext = pathinfo($nota->file_nota, PATHINFO_EXTENSION); @endphp
                                @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                    <a href="{{ Storage::url($nota->file_nota) }}" target="_blank">
                                        <img src="{{ Storage::url($nota->file_nota) }}" alt="Nota" class="img-thumbnail" style="max-width: 80px;">
                                    </a>
                                @else
                                    <a href="{{ Storage::url($nota->file_nota) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-file-pdf"></i> Lihat File
                                    </a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('sopir.nota-pengeluaran.edit', $nota->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-hapus-{{ $nota->id }}" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Modal Hapus --}}
                        <div class="modal fade" id="modal-hapus-{{ $nota->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        Yakin ingin menghapus nota <strong>{{ ucfirst($nota->jenis) }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <form action="{{ route('sopir.nota-pengeluaran.destroy', $nota->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada nota diunggah.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

@endsection
