@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<h3 class="mb-4">Dashboard</h3>
<div class="row g-3 mb-4">
    <div class="col-md-6"><div class="card p-4"><div class="text-muted">Jumlah Katalog</div><h2>{{ $jumlahDonasis }}</h2></div></div>
    <div class="col-md-6"><div class="card p-4"><div class="text-muted">Transaksi Menunggu</div><h2>{{ $jumlahMenunggu }}</h2></div></div>
    <div class="col-md-6"><div class="card p-4"><div class="text-muted">Total Porsi Disetujui</div><h2>{{ $totalPorsiDisetujui }}</h2></div></div>
</div>
<div class="card p-4">
    <h5>Transaksi Terbaru</h5>
    @if($PengajuanTerbaru->isEmpty())<p class="text-muted mb-0">Belum ada Pengajuan.</p>
    @else
    <div class="table-responsive"><table class="table mb-0"><thead><tr><th>Pangan</th><th>Porsi</th><th>Pengaju</th><th>Status</th></tr></thead>
    <tbody>@foreach($PengajuanTerbaru as $item)<tr><td>{{ $item->donasi?->nama_pangan }}</td><td>{{ $item->jumlah_porsi }}</td><td>{{ $item->user?->name }}</td><td>{{ $item->status }}</td></tr>@endforeach</tbody></table></div>
    @endif
</div>
@endsection
