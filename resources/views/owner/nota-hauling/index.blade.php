@extends('layout.main')
@include('partials.sidebar-owner')

@section('title', 'Nota Hauling')

@section('content')
<div class="container mt-4">
    <h4>Nota Hauling</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('owner.nota-hauling.index') }}" class="form-inline mb-3">
        <div class="form-group mr-2">
            <label class="mr-1">Dari</label>
            <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
        </div>
        <div class="form-group mr-2">
            <label class="mr-1">Sampai</label>
            <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Sopir</th>
                <th>Jumlah Ritase</th>
                <th>Tarif / Rit</th>
                <th>Total</th>
                <th>Bukti Transfer</th>
                <th>Nota Perjalanan</th>
                <th>Status / Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($notas as $nota)
            <tr>
                <td>{{ \Carbon\Carbon::parse($nota->tanggal)->format('d M Y') }}</td>
                <td>{{ $nota->sopir->nama ?? '-' }}</td>
                <td>{{ $nota->jumlah_ritase }}</td>
                <td>Rp {{ number_format($nota->tarif_per_rit,0,',','.') }}</td>
                <td>Rp {{ number_format($nota->jumlah_ritase * $nota->tarif_per_rit,0,',','.') }}</td>
                <td>
                    @if($nota->bukti_transfer)
                        <a href="{{ asset('storage/'.$nota->bukti_transfer) }}" target="_blank">Lihat</a>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    @if($nota->file_nota)
                        <a href="{{ asset('storage/'.$nota->file_nota) }}" target="_blank">Lihat Nota</a>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    @if($nota->status == 'MENUNGGU')
                        <span class="badge bg-warning clickable" onclick="showActions({{ $nota->id }})" id="menunggu-{{ $nota->id }}">Menunggu</span>
                        <div id="actions-{{ $nota->id }}" style="display:none;">
                            <form action="{{ route('owner.nota-hauling.approve', $nota->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form action="{{ route('owner.nota-hauling.reject', $nota->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        </div>
                    @elseif($nota->status == 'approved')
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Belum ada data nota hauling</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function showActions(id) {
    document.getElementById('menunggu-' + id).style.display = 'none';
    document.getElementById('actions-' + id).style.display = 'inline';
}
</script>
@endsection