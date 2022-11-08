<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Toko;
use App\Models\Driver;
use Illuminate\Http\Request;

use Illuminate\Support\HtmlString;


class StoreController extends Controller
{
    public function index()
    {
        $toko = Toko::where('kode_toko', auth()->user()->name)->value('id');
        return view('store.index', [
            "title" => "Konfirmasi",
            "nama" => auth()->user()->name,
            "pengirimans" => Pengiriman::with(['toko', 'driver'])
                ->where([
                    ['status', 1,],
                    ['toko_id', $toko]
                ])->latest('updated_at')->get()
        ]);
    }

    public function laporan()
    {
        $toko = Toko::where('kode_toko', auth()->user()->name)->value('id');
        return view('store.laporan', [
            "title" => "Laporan Pengiriman",
            "nama" => auth()->user()->name,
            "pengirimans" => Pengiriman::with(['toko', 'driver'])->where('toko_id', $toko)->latest('updated_at')->get(),
            "data" => collect([
                'tanggalawal' => '',
                'tanggalakhir' => ''
            ])
        ]);
    }

    public function laporanSearch(Request $request)
    {
        $toko = Toko::where('kode_toko', auth()->user()->name)->value('id');
        return view('store.laporan', [
            "title" => "Laporan Pengiriman",
            "nama" => auth()->user()->name,
            "pengirimans" => Pengiriman::with(['toko', 'driver'])
                ->where('toko_id', $toko)
                ->whereBetween('tanggal', [$request["tanggalawal"], $request["tanggalakhir"]])->latest('tanggal')->get(),
            "data" => collect([
                "tanggalawal" => $request["tanggalawal"],
                "tanggalakhir" => $request["tanggalakhir"]
            ])
        ]);
    }

    public function konfirmasi(Pengiriman $pengiriman, Request $request)
    {
        $waktu_terima = date("H:i:s");
        Pengiriman::where('id', $pengiriman->id)
            ->update([
                'status' => 2,
                'waktu_terima' => $waktu_terima,
                'penerima' => $request['penerima'],
                'keterangan' => $request['keterangan']
            ]);

        $pesan = new HtmlString('Pengiriman <b>' . strtoupper($pengiriman->no_stpb) . '</b> Diterima');
        return redirect('/store')->with('success', $pesan);
    }

    public function laporanDetail(Pengiriman $pengiriman)
    {
        abort_if($pengiriman->status !== 2, 403, 'Pengiriman Belum Selesai'); //Tidak dapat diakses apabila pengiriman belum selesai

        return view('pengiriman.detail', [
            "title" => "Detail Pengiriman",
            "nama" => auth()->user()->name,
            "pengiriman" => $pengiriman,
            "toko" => Toko::select('kode_toko', 'nama_toko', 'alamat')->where('id', $pengiriman->toko_id)->get()[0],
            "driver" => Driver::select('id', 'nik', 'nama', 'email', 'no_telepon')->where('id', $pengiriman->toko_id)->get()[0]
        ]);
    }
}
