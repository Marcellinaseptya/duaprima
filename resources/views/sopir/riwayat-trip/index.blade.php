@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Riwayat Trip')

@section('content')
<div class="container mt-4">
    <h3>📜 Riwayat Perjalanan</h3>
    <p class="text-muted">Lihat catatan semua perjalanan Anda.</p>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>Tanggal</th>
                    <th>Klien</th>
                    <th>Truk</th>
                    <th>Status</th>
                    <th>Uang Jalan</th>
                    <th>Muatan Netto</th>
                    <th>Ritase</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwals as $jadwal)
                    <tr class="text-center">
                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</td>
                        <td>{{ $jadwal->klien->nama_perusahaan ?? '-' }}</td>
                        <td>{{ $jadwal->truk->plat_nomor ?? '-' }}</td>
                        <td>
                            @php
                                $badge = 'secondary';
                                if ($jadwal->status === 'Siap Berangkat') $badge = 'warning';
                                elseif ($jadwal->status === 'Berangkat') $badge = 'info';
                                elseif ($jadwal->status === 'Pulang') $badge = 'success';
                                elseif (str_contains($jadwal->status, 'Batal')) $badge = 'danger';
                            @endphp
                            <span class="badge bg-{{ $badge }}">
                                {{ $jadwal->status }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($jadwal->uang_jalan ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $jadwal->muatan_netto ?? '-' }}</td>
                        <td>{{ $jadwal->ritase ?? '-' }}</td>
                        <td>{{ $jadwal->waktu_mulai ? \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('d M Y H:i') : '-' }}</td>
                        <td>{{ $jadwal->waktu_selesai ? \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('d M Y H:i') : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            <i class="fas fa-info-circle"></i> Belum ada riwayat perjalanan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
