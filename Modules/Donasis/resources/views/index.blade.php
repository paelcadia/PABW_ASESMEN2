@extends('layouts.app')
@section('title', 'Donasis')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <h3 class="mb-2">Katalog Donasi Pangan</h3>
    @if(auth()->user()->role === 'admin')<a href="{{ route('Donasis.create') }}" class="btn btn-primary">Tambah Donasis</a>@endif
</div>
<div class="card p-3">
    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-4"><input class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari kode atau nama pangan"></div>
        <div class="col-md-4"><input class="form-control" name="lokasi" value="{{ request('lokasi') }}" placeholder="Filter lokasi ambil"></div>
        <div class="col-auto"><button class="btn btn-outline-primary">Cari</button></div>
    </form>
    <div class="table-responsive"><table class="table table-hover">
        <thead><tr><th>Kode</th><th>Nama Pangan</th><th>Lokasi Ambil</th><th>Batas Porsi</th><th>Tanggal Bagi</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($Donasis as $item)
            <tr><td>{{ $item->kode_donasi }}</td><td>{{ $item->nama_pangan }}</td><td>{{ $item->lokasi_ambil }}</td>
            <td><span class="badge text-bg-secondary">{{ $item->batas_porsi }}</span></td><td>{{ $item->tanggal_bagi }}</td>
            <td>@if(auth()->user()->role === 'admin')
                <a href="{{ route('Donasis.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('Donasis.destroy', $item) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger" onclick="return confirm('Hapus Donasis?')">Hapus</button></form>
            @else <span class="text-muted">-</span> @endif</td></tr>
        @empty
            <tr><td colspan="4" class="text-center text-muted">Belum ada data.</td></tr>
        @endforelse
        </tbody>
    </table></div>
    {{ $Donasis->links() }}
</div>
@endsection
