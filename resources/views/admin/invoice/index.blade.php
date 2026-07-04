@extends('layout.main')
@include('partials.sidebar-admin')

@section('title', 'Invoice Ritase')

@section('content')
<div class="container-fluid mt-3">
    <h1>Invoice Ritase</h1>

    <form method="GET" action="{{ route('admin.invoice.index') }}">
        <div class="row">
            <div class="col-md-3">
                <label>Dari Tanggal</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>
            <div class="col-md-3">
                <label>Sampai Tanggal</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>
            <div class="col-md-3">
                <label>Klien</label>
                <select name="klien_id" class="form-control">
                    <option value="">-- Semua Klien --</option>
                    @foreach($kliens as $klien)
                        <option value="{{ $klien->id }}" {{ request('klien_id') == $klien->id ? 'selected' : '' }}>
                            {{ $klien->nama_perusahaan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary mr-2">Filter</button>
                <a href="{{ route('admin.invoice.export', request()->all()) }}" class="btn btn-danger">Export PDF</a>
            </div>
        </div>
    </form>

    <div class="table-responsive mt-3">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Sopir</th>
                    <th>Tujuan</th>
                    <th>Muatan Netto</th>
                    <th>Tarif</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($ritases as $ritase)
                    @php
                        $sub = $ritase->muatan_netto * $ritase->tarif;
                        $total += $sub;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ritase->created_at->format('d-m-Y') }}</td>
                        <td>{{ $ritase->tripBerangkat->sopir->nama ?? '-' }}</td>
                        <td>{{ $ritase->tripBerangkat->tujuan ?? '-' }}</td>
                        <td>{{ number_format($ritase->muatan_netto) }} kg</td>
                        <td>Rp{{ number_format($ritase->tarif) }}</td>
                        <td>Rp{{ number_format($sub) }}</td>
                    </tr>
                @endforeach
                <tr class="font-weight-bold">
                    <td colspan="6" class="text-right">TOTAL TAGIHAN</td>
                    <td>Rp{{ number_format($total) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection