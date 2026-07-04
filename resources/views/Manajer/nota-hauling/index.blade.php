@extends('layout.main')
@include('partials.sidebar-manajer')

@section('title', 'Nota Hauling')

@section('content')
<div class="container-fluid mt-4">
    <h3 class="mb-3">📄 Nota Hauling</h3>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jumlah Ritase</th>
                        <th>Tarif per Rit</th>
                        <th>Total Pemasukan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($notaHauling as $nota)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($nota->tanggal)->format('d-m-Y') }}</td>
                            <td class="text-center">{{ $nota->jumlah_ritase }}</td>
                            <td class="text-end">Rp{{ number_format($nota->tarif_per_rit, 0, ',', '.') }}</td>
                            <td class="text-end">Rp{{ number_format($nota->total_pemasukan, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if($nota->status == 'Menunggu')
                                    <span class="badge" style="background-color: #ffc107; color: #212529; font-weight: 500;">⏳ Menunggu</span>
                                @elseif($nota->status == 'Approved')
                                    <span class="badge" style="background-color: #28a745; color: #fff; font-weight: 500;">✅ Approved</span>
                                @elseif($nota->status == 'Rejected')
                                    <span class="badge" style="background-color: #dc3545; color: #fff; font-weight: 500;">❌ Rejected</span>
                                @else
                                    <span class="badge bg-secondary">{{ $nota->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data nota hauling.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
