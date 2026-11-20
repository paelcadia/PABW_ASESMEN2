<?php

namespace Modules\Donasis\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Donasis\Http\Requests\StoreDonasisRequest;
use Modules\Donasis\Http\Requests\UpdateDonasisRequest;
use Modules\Donasis\Models\Donasis;

class DonasisController extends Controller
{
    public function index(Request $request)
    {
        $Donasis = Donasis::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('kode_donasi', 'like', "%{$search}%")
                      ->orWhere('nama_pangan', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('lokasi'), function ($query) use ($request) {
                $query->where('lokasi_ambil', 'like', '%' . $request->lokasi . '%');
            })
            ->orderBy('kode_donasi')
            ->paginate(10)
            ->withQueryString();

        return view('Donasis::index', compact('Donasis'));
    }

    public function create()
    {
        return view('Donasis::create');
    }

    public function store(StoreDonasisRequest $request)
    {
        Donasis::create($request->validated());
        return redirect()->route('Donasis.index')->with('success', 'Donasis berhasil ditambahkan.');
    }

    public function edit(Donasis $Donasi)
    {
        return view('Donasis::edit', ['Donasis' => $Donasi]);
    }

    public function update(UpdateDonasisRequest $request, Donasis $Donasi)
    {
        $data = $request->validated();
        if ($Donasi->pengajuans()->exists()) {
            $data['batas_porsi'] = $Donasi->batas_porsi;
            $data['tanggal_bagi'] = $Donasi->tanggal_bagi;
        }
        $Donasi->update($data);
        return redirect()->route('Donasis.index')->with('success', 'Donasis berhasil diperbarui.');
    }

    public function destroy(Donasis $Donasi)
    {
        if ($Donasi->pengajuans()->exists()) {
            return redirect()->route('Donasis.index')
                ->with('error', 'Donasi tidak dapat dihapus karena sudah memiliki pengajuan.');
        }
        $Donasi->delete();
        return redirect()->route('Donasis.index')->with('success', 'Donasis berhasil dihapus.');
    }
}
