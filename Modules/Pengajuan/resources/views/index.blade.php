@extends('layouts.app')
@section('title', 'Pengajuan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Pengajuan Bantuan</h3>
    @if(auth()->user()->role === 'pemohon')
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#pengajuanModal" onclick="openCreate()">Tambah Pengajuan</button>
    @endif
</div>
<div id="alertArea"></div>
<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover" id="pengajuanTable">
            <thead><tr><th>Kode/Nama</th><th>Porsi</th><th>Tanggal Ambil</th><th>Status</th><th>Pengaju</th><th>Bukti</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($Pengajuans as $item)
                <tr id="row-{{ $item->id }}">
                    <td>{{ $item->donasi?->kode_donasi }} - {{ $item->donasi?->nama_pangan }}</td>
                    <td>{{ $item->jumlah_porsi }}</td>
                    <td>{{ $item->tanggal_ambil }}</td>
                    <td><span class="badge @if($item->status==='Menunggu') text-bg-warning @elseif($item->status==='Disetujui') text-bg-success @else text-bg-danger @endif">{{ $item->status }}</span></td>
                    <td>{{ $item->user?->name }}</td>
                    <td>@if($item->foto_bukti)<a href="{{ asset('storage/'.$item->foto_bukti) }}" target="_blank">Lihat Bukti</a>@else-@endif</td>
                    <td>
                        @if(auth()->user()->role === 'pemohon' && $item->user_id === auth()->id() && $item->status === 'Menunggu')
                            <button class="btn btn-sm btn-warning" type="button" onclick="openEdit({{ $item->id }})">Edit</button>
                            <button class="btn btn-sm btn-danger" type="button" onclick="deleteData({{ $item->id }})">Hapus</button>
                        @endif
                        @if(auth()->user()->role === 'admin')
                            @if($item->status === 'Menunggu')
                                <button class="btn btn-sm btn-success" type="button" onclick="updateStatus({{ $item->id }}, 'Disetujui')">Setujui</button>
                                <button class="btn btn-sm btn-danger" type="button" onclick="updateStatus({{ $item->id }}, 'Ditolak')">Tolak</button>
                            @endif
                            <button class="btn btn-sm btn-outline-danger ms-1" type="button" onclick="deleteData({{ $item->id }})">Hapus</button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr id="emptyRow"><td colspan="7" class="text-center text-muted">Belum ada pengajuan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(auth()->user()->role === 'pemohon')
<div class="modal fade" id="pengajuanModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title" id="modalTitle">Tambah Pengajuan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <form id="pengajuanForm" enctype="multipart/form-data">
        <input type="hidden" id="pengajuanId">
        <div class="modal-body">
            <div id="formErrors" class="alert alert-danger d-none"></div>
            <div class="mb-3"><label class="form-label">Donasi</label><select name="donasi_id" id="donasi_id" class="form-select"><option value="">Pilih donasi</option>@foreach($Donasis as $item)<option value="{{ $item->id }}">{{ $item->kode_donasi }} - {{ $item->nama_pangan }} (maks. {{ $item->batas_porsi }}, {{ $item->tanggal_bagi }})</option>@endforeach</select><div class="invalid-feedback" data-error="donasi_id"></div></div>
            <div class="mb-3"><label class="form-label">Jumlah Porsi</label><input type="number" min="1" name="jumlah_porsi" id="jumlah_porsi" class="form-control"><div class="invalid-feedback" data-error="jumlah_porsi"></div></div>
            <div class="mb-3"><label class="form-label">Tanggal Ambil</label><input type="date" name="tanggal_ambil" id="tanggal_ambil" class="form-control"><div class="invalid-feedback" data-error="tanggal_ambil"></div></div>
            <div class="mb-3"><label class="form-label">Keperluan</label><textarea name="keperluan" id="keperluan" class="form-control"></textarea><div class="invalid-feedback" data-error="keperluan"></div></div>
            <div class="mb-3"><label class="form-label">Foto Bukti (opsional)</label><input type="file" name="foto_bukti" id="foto_bukti" accept="image/jpeg,image/png" class="form-control"><div class="invalid-feedback" data-error="foto_bukti"></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button></div>
    </form>
</div></div></div>
@endif
@endsection

@section('scripts')
<script>
const csrf = document.querySelector('meta[name="csrf-token"]').content;
let modal;
function getModal(){ return modal ||= bootstrap.Modal.getOrCreateInstance(document.getElementById('pengajuanModal')); }
function openCreate(){
    document.getElementById('pengajuanForm').reset();
    document.getElementById('pengajuanId').value='';
    document.getElementById('modalTitle').textContent='Tambah Pengajuan';
    document.getElementById('formErrors').classList.add('d-none');
}
async function openEdit(id){
    const res=await fetch(`{{ url('/Pengajuans') }}/${id}/edit`,{headers:{Accept:'application/json','X-CSRF-TOKEN':csrf}});
    const json=await res.json();
    if(!res.ok){ alert(json.message||'Akses ditolak'); return; }
    document.getElementById('pengajuanId').value=id;
    document.getElementById('donasi_id').value=json.data.donasi_id;
    document.getElementById('jumlah_porsi').value=json.data.jumlah_porsi;
    document.getElementById('tanggal_ambil').value=json.data.tanggal_ambil;
    document.getElementById('keperluan').value=json.data.keperluan;
    document.getElementById('modalTitle').textContent='Edit Pengajuan';
    getModal().show();
}
document.getElementById('pengajuanForm')?.addEventListener('submit',async function(e){
    e.preventDefault();
    const id=document.getElementById('pengajuanId').value;
    const form=new FormData(this); if(id) form.append('_method','PUT');
    const submit=document.getElementById('submitBtn');
    submit.disabled=true; submit.innerHTML='<span class="spinner-border spinner-border-sm"></span> Memproses';
    document.querySelectorAll('[data-error]').forEach(el=>el.textContent='');
    try{
        const res=await fetch(id?`{{ url('/Pengajuans') }}/${id}`:`{{ route('Pengajuan.store') }}`,{method:'POST',body:form,headers:{'X-CSRF-TOKEN':csrf,Accept:'application/json'}});
        const json=await res.json().catch(()=>({}));
        if(!res.ok){
            const box=document.getElementById('formErrors');
            box.textContent=res.status===403?(json.message||'Anda tidak memiliki izin.'):((json.errors?Object.values(json.errors).flat():[json.message]).join(' '));
            box.classList.remove('d-none');
            if(json.errors) Object.entries(json.errors).forEach(([field,messages])=>{const el=document.querySelector(`[data-error="${field}"]`); if(el){el.textContent=messages.join(' '); el.closest('.mb-3').querySelector('.form-control')?.classList.add('is-invalid');}});
            return;
        }
        getModal().hide();
        document.getElementById('alertArea').innerHTML=`<div class="alert alert-success">${json.message}</div>`;
        setTimeout(()=>location.reload(),500);
    }catch(error){
        const box=document.getElementById('formErrors'); box.textContent='Tidak dapat menghubungi server.'; box.classList.remove('d-none');
    }finally{submit.disabled=false;submit.textContent='Simpan';}
});
async function deleteData(id){
    if(!confirm('Hapus pengajuan ini?'))return;
    const res=await fetch(`{{ url('/Pengajuans') }}/${id}`,{method:'DELETE',headers:{'X-CSRF-TOKEN':csrf,Accept:'application/json'}});
    const json=await res.json().catch(()=>({}));
    if(res.ok){document.getElementById(`row-${id}`)?.remove();document.getElementById('alertArea').innerHTML=`<div class="alert alert-success">${json.message}</div>`;}
    else{document.getElementById('alertArea').innerHTML=`<div class="alert alert-danger">${json.message||'Tindakan ditolak.'}</div>`;}
}
async function updateStatus(id,status){
    const res=await fetch(`{{ url('/Pengajuans') }}/${id}/status`,{method:'PATCH',headers:{'X-CSRF-TOKEN':csrf,Accept:'application/json','Content-Type':'application/json'},body:JSON.stringify({status})});
    const json=await res.json().catch(()=>({}));
    if(res.ok){document.getElementById('alertArea').innerHTML=`<div class="alert alert-success">${json.message}</div>`;setTimeout(()=>location.reload(),400);}
    else{document.getElementById('alertArea').innerHTML=`<div class="alert alert-danger">${json.message||'Keputusan ditolak.'}</div>`;}
}
</script>
@endsection
