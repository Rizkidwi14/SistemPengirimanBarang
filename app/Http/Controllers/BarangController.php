<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\RiwayatPerubahanStok;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('barang.index', [
            "title" => "Barang",
            "nama" => auth()->user()->name,
            "barangs" => Barang::latest()->get(),
        ]);
    }

    public function riwayat()
    {
        return view('barang.riwayat', [
            "title" => "Riwayat Perubahan Stok",
            "nama" => auth()->user()->name,
            "riwayats" => RiwayatPerubahanStok::latest('updated_at')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Cek Kategori Barang Input
        if ($request->kategori == "reguler") {
            $kategori = Barang::where('kategori', 'reguler')->max('kode');
            $kategori ? $kategori++ : $kategori = "B0001";
        } else {
            $kategori = Barang::where('kategori', 'fresh food')->max('kode');
            $kategori ? $kategori++ : $kategori = "F0001";
        }

        // Delete Leading Zero(s)
        $request['stok'] = ltrim($request['stok'], "0");

        $validatedData = $request->validate(
            [
                'kategori' => 'required',
                'namaBarang' => 'required',
                'stok' => 'required|integer|min:0'
            ],
            [
                'stok.min' => 'Stok Tidak Boleh Dibawah Negatif',
            ]
        );

        // Ambil Kode Barang Dari Cek Kategori
        // sesuaikan nama barang dengan field di database
        $validatedData['kode'] = $kategori;
        $validatedData['nama'] = $validatedData['namaBarang'];

        Barang::create($validatedData);
        return redirect('/barang')->with('success', 'Data Barang Berhasil Ditambah!');
    }

    public function ubahStok(Barang $barang, Request $request)
    {
        $stokSistem = $barang->stok;
        $stokFisik = $request->stokFisik;
        $selisih = abs($stokFisik - $stokSistem);

        // Cek Keterangan Selisih
        if ($stokFisik > $stokSistem) {
            $keterangan = 'positif';
        } else if ($stokFisik < $stokSistem) {
            $keterangan = 'negatif';
        } else {
            $keterangan = '';
        }

        // Update Barang dan Buat Riwayat Perubaha Stok
        Barang::where('id', $barang->id)->update(['stok' => $stokFisik]);
        RiwayatPerubahanStok::create([
            'kode_barang' => $barang->kode,
            'nama_barang' => $barang->nama,
            'stok_sistem' => $stokSistem,
            'stok_fisik' => $stokFisik,
            'selisih' => $selisih,
            'keterangan' => $keterangan,
        ]);

        return redirect('/barang')->with('success', 'Stok Berhasil Diubah');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     * 
     */
    public function update(Request $request, Barang $barang)
    {
        // Kode Kategori Barang Di Sistem dan Input
        $kategoriSistem = substr($barang->kode, 0, 1);
        $kategoriInput = strtoupper(substr($request->kodeBarang, 0, 1));

        // Cek Kategori di Kode Barang
        if ($kategoriSistem !== $kategoriInput) {
            return redirect()->back()->with('failed', ' Kode Kategori Tidak Boleh Beda');
        }

        $validatedData = $request->validate([
            'kodeBarang' => 'required|alpha_num|unique:barangs,kode,' . $barang->id,
            'namaBarang' => 'required'
        ]);

        Barang::where('id', $barang->id)->update([
            "kode" => $validatedData['kodeBarang'],
            "nama" => $validatedData['namaBarang']
        ]);

        $pesan = new HtmlString('Data Barang <b>' . strtoupper($validatedData['kodeBarang']) . '</b> Berhasil Diubah!');
        return redirect('/barang')->with('success', $pesan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        Barang::destroy('id', $barang->id);
        return redirect('/barang')->with('success', 'Data Barang Berhasil Dihapus');
    }
}
