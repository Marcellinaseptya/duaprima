@extends('layout.main')
@include('partials.sidebar-manajer')

@section('title', 'Nota Pengeluaran')

@section('content')
<div class="container-fluid mt-3">
    <h1 class="mb-3">📄 Review Nota Pengeluaran</h1>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Keterangan</th>
                        <th>File</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($notaPengeluaran as $nota)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($nota->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ ucfirst($nota->jenis) }}</td>
                            <td>{{ $nota->keterangan ?? '-' }}</td>
                            <td class="text-center">
                                @if($nota->file_nota)
                                    <a href="{{ Storage::url($nota->file_nota) }}" target="_blank" class="text-decoration-none">📎 Lihat Nota</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($nota->status == 'MENUNGGU')
                                    <span class="badge" style="background-color: #ffc107; color: #212529; font-weight: 500;">⏳ Menunggu</span>
                                @elseif($nota->status == 'APPROVED')
                                    <span class="badge" style="background-color: #28a745; color: #fff; font-weight: 500;">✅ Approved</span>
                                @elseif($nota->status == 'REJECTED')
                                    <span class="badge" style="background-color: #dc3545; color: #fff; font-weight: 500;">❌ Rejected</span>
                                @else
                                    <span class="badge bg-secondary">{{ $nota->status ?? '-' }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada nota pengeluaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
