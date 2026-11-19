<?php

namespace App\Http\Controllers;

use App\Models\Cars;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $data_mobil = Cars::where(
            'nama_mobil',
            'LIKE',
            "%$search%"
        )->get();

        return view('pages.data_mobil.show', compact('data_mobil'));
    }

    public function create()
    {
        return view('pages.data_mobil.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mobil' => 'required',
            'merk' => 'required',
            'tipe' => 'required',
            'tahun' => 'required',
            'plat_nomor' => 'required',
            'harga_sewa' => 'required',
            'status' => 'required',
        ], [
            'nama_mobil.required'=>'Nama mobil wajib diisi',
            'merk.required'=>'Merk mobil wajib diisi',
            'tipe.required'=>'Tipe mobil wajib diisi',
            'tahun.required'=>'Tahun mobil wajib diisi',
            'plat_nomor.required'=>'Plat nomor mobil wajib diisi',
            'harga_sewa.required'=>'Harga sewa mobil wajib diisi',
            'status.required'=>'Status mobil wajib diisi',
        ]);

        Cars::create([
            'nama_mobil' => $request->nama_mobil,
            'merk' => $request->merk,
            'tipe' => $request->tipe,
            'tahun' => $request->tahun,
            'plat_nomor' => $request->plat_nomor,
            'harga_sewa' => $request->harga_sewa,
            'status' => $request->status,
        ]);

        return redirect('/data-mobil')->with('pesan', 'data berhasil ditambahkan');
    }

    public function edit($id) {
        $data_mobil = Cars::findOrFail($id);

        return view('pages.data_mobil.form', compact('data_mobil'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nama_mobil' => 'required',
            'merk' => 'required',
            'tipe' => 'required',
            'tahun' => 'required',
            'plat_nomor' => 'required',
            'harga_sewa' => 'required',
            'status' => 'required',
        ], [
            'nama_mobil.required'=>'Nama mobil wajib diisi',
            'merk.required'=>'Merk mobil wajib diisi',
            'tipe.required'=>'Tipe mobil wajib diisi',
            'tahun.required'=>'Tahun mobil wajib diisi',
            'plat_nomor.required'=>'Plat nomor mobil wajib diisi',
            'harga_sewa.required'=>'Harga sewa mobil wajib diisi',
            'status.required'=>'Status mobil wajib diisi',
        ]);

        $mobil = Cars::findOrFail($id);

        $mobil->update([
            'nama_mobil' => $request->nama_mobil,
            'merk' => $request->merk,
            'tipe' => $request->tipe,
            'tahun' => $request->tahun,
            'plat_nomor' => $request->plat_nomor,
            'harga_sewa' => $request->harga_sewa,
            'status' => $request->status,
        ]);

        return redirect('/data-mobil');
    }

    public function destroy($id) {
        Cars::findOrFail($id)->delete();
        return redirect('/data-mobil');
    }
}
