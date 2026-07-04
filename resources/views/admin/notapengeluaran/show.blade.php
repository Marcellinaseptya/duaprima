@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Detail Nota')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Detail Nota</h4>

    <div class="card">
        <div class="card-body">
            <p><strong>Sopir:</strong> {{ $nota->sopir->nama ?? '-' }}</p>
            <p><strong>Jenis Nota:</strong> {{ $nota->jenis_nota }}</p>
            <p><strong>Tanggal Upload:</strong> {{ \Carbon\Carbon::parse($nota->tanggal_upload)->format('d-m-Y H:i') }}</p>
            <p><strong>Keterangan:</strong> {{ $nota->keterangan ?? '-' }}</p>
            <p><strong>File:</strong><br>
                <a href="{{ Storage::url($nota->file_path) }}" target="_blank">Lihat / Unduh</a>
            </p>
            <a href="{{ route('admin.nota.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>
@endsection
