<?php

namespace Modules\Pengajuan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Donasis\Models\Donasis;
use Modules\Pengajuan\Http\Requests\StorePengajuanRequest;
use Modules\Pengajuan\Http\Requests\UpdatePengajuanRequest;
use Modules\Pengajuan\Http\Requests\DecisionPengajuanRequest;
use Modules\Pengajuan\Models\Pengajuan;

class PengajuanController extends Controller
{
    public function index()
    {
        $query = Pengajuan::with(['donasi', 'user'])->latest();
        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        return view('Pengajuan::index', [
            'Pengajuans' => $query->get(),
            'Donasis' => Donasis::orderBy('kode_donasi')->get(),
        ]);
    }

    public function create()
    {
        return redirect()->route('Pengajuan.index');
    }

    public function store(StorePengajuanRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['status'] = 'Menunggu';
        unset($data['user_id_payload'], $data['status_payload']);

        if ($request->hasFile('foto_bukti')) {
            $data['foto_bukti'] = $request->file('foto_bukti')->store('pengajuan', 'public');
        }

        $Pengajuan = Pengajuan::create($data);
        $Pengajuan->load(['donasi', 'user']);

        return response()->json([
            'message' => 'Pengajuan berhasil ditambahkan.',
            'data' => $Pengajuan,
        ], 201);
    }

    public function show(Pengajuan $Pengajuan)
    {
        abort_unless(auth()->user()->role === 'admin' || $Pengajuan->user_id === auth()->id(), 403);
        return response()->json(['data' => $Pengajuan->load(['donasi', 'user'])]);
    }

    public function edit(Pengajuan $Pengajuan)
    {
        abort_unless(auth()->user()->role === 'admin' || $Pengajuan->user_id === auth()->id(), 403);
        abort_if(auth()->user()->role === 'pemohon' && $Pengajuan->status !== 'Menunggu', 403);
        return response()->json(['data' => $Pengajuan->load('donasi')]);
    }

    public function update(UpdatePengajuanRequest $request, Pengajuan $Pengajuan)
    {
        abort_unless(auth()->user()->role === 'pemohon' && $Pengajuan->user_id === auth()->id(), 403);
        abort_unless($Pengajuan->status === 'Menunggu', 403);

        $data = $request->validated();
        if ($request->hasFile('foto_bukti')) {
            if ($Pengajuan->foto_bukti) {
                Storage::disk('public')->delete($Pengajuan->foto_bukti);
            }
            $data['foto_bukti'] = $request->file('foto_bukti')->store('pengajuan', 'public');
        } else {
            unset($data['foto_bukti']);
        }
        $Pengajuan->update($data);

        $Pengajuan->load(['donasi', 'user']);
        return response()->json([
            'message' => 'Pengajuan berhasil diperbarui.',
            'data' => $Pengajuan,
        ]);
    }

    public function destroy(Pengajuan $Pengajuan)
    {
        if (auth()->user()->role === 'pemohon') {
            abort_unless($Pengajuan->user_id === auth()->id(), 403);
            abort_unless($Pengajuan->status === 'Menunggu', 403);
        }

        if ($Pengajuan->foto_bukti) {
            Storage::disk('public')->delete($Pengajuan->foto_bukti);
        }
        $Pengajuan->delete();

        return response()->json(['message' => 'Pengajuan berhasil dihapus.']);
    }

    public function updateStatus(DecisionPengajuanRequest $request, Pengajuan $Pengajuan)
    {
        abort_unless(auth()->user()->role === 'admin', 403);
        abort_unless($Pengajuan->status === 'Menunggu', 403);
        $request->validate(['status' => ['required', 'in:Disetujui,Ditolak']]);
        $Pengajuan->update(['status' => $request->status]);

        return response()->json(['message' => 'Status Pengajuan diperbarui.', 'data' => $Pengajuan]);
    }
}
