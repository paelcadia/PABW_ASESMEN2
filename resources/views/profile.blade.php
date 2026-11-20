@extends('layouts.app')
@section('title', 'Profil')
@section('content')
<div class="card p-4"><h4>Profil Pengguna</h4><hr>
    <dl class="row mb-0">
        <dt class="col-sm-3">Nama</dt><dd class="col-sm-9">{{ auth()->user()->name }}</dd>
        <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ auth()->user()->email }}</dd>
        <dt class="col-sm-3">Role</dt><dd class="col-sm-9 text-capitalize">{{ auth()->user()->role }}</dd>
    </dl>
</div>
@endsection
