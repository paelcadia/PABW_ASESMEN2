@extends('layouts.app')
@section('title', 'Edit Donasis')
@section('content')
<div class="card p-4"><h4>Edit Donasis</h4>
<form method="POST" action="{{ route('Donasis.update', $Donasis) }}">@csrf @method('PUT')
@include('Donasis::form')
<button class="btn btn-primary">Perbarui</button> <a href="{{ route('Donasis.index') }}" class="btn btn-secondary">Kembali</a>
</form></div>
@endsection
