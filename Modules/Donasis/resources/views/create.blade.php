@extends('layouts.app')
@section('title', 'Tambah Donasis')
@section('content')
<div class="card p-4"><h4>Tambah Donasis</h4>
<form method="POST" action="{{ route('Donasis.store') }}">@csrf
@include('Donasis::form')
<button class="btn btn-primary">Simpan</button> <a href="{{ route('Donasis.index') }}" class="btn btn-secondary">Kembali</a>
</form></div>
@endsection
