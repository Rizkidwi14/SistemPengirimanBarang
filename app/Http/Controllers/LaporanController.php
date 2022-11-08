<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Toko;
use App\Models\Driver;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporanPengiriman()
    {
        return view('pengiriman.laporan', [
            "title" => "Laporan Pengiriman",
            "nama" => auth()->user()->name,
            "pengirimans" => Pengiriman::with(['toko', 'driver'])->latest('no_stpb')->get(),
            "data" => collect([
                'toko' => '',
                'tanggalawal' => '',
                'tanggalakhir' => ''
            ])
        ]);
    }

    public function detailPengiriman(Pengiriman $pengiriman)
    {
        abort_if($pengiriman->status !== 2, 403, 'Pengiriman Belum Selesai'); //Tidak dapat diakses apabila pengiriman belum selesai

        return view('pengiriman.detail', [
            "title" => "Detail Pengiriman",
            "nama" => auth()->user()->name,
            "pengiriman" => $pengiriman,
            "toko" => Toko::select('kode_toko', 'nama_toko', 'alamat')->where('id', $pengiriman->toko_id)->withTrashed()->get()[0],
            "driver" => Driver::select('nik', 'nama', 'email', 'no_telepon')->where('id', $pengiriman->driver_id)->withTrashed()->get()[0]
        ]);
    }

    public function laporanPengirimanSearch(Request $request)
    {

        if ($request['toko']) {
            $tokoId = Toko::where('kode_toko', $request['toko'])->value('id');
            if (!$tokoId) {
                return redirect()->back()->with('failed', 'Kode Toko Tidak Ada');
            } else {
                $pengirimans = Pengiriman::with(['toko', 'driver'])->where('toko_id', $tokoId)
                    ->whereBetween('tanggal', [$request["tanggalawal"], $request["tanggalakhir"]])
                    ->latest('updated_at')->get();
            }
        } else {
            $pengirimans = Pengiriman::with(['toko', 'driver'])
                ->whereBetween('tanggal', [$request["tanggalawal"], $request["tanggalakhir"]])
                ->latest('updated_at')->get();
        }
        return view('pengiriman.laporan', [
            "title" => "Pengiriman",
            "nama" => auth()->user()->name,
            "pengirimans" => $pengirimans,
            "data" => collect([
                "toko" => $request["toko"],
                "tanggalawal" => $request["tanggalawal"],
                "tanggalakhir" => $request["tanggalakhir"],
            ])
        ]);
    }

    public function laporanPengirimanCetak()
    {
        return view('pengiriman.cetak', [
            "title" => "Pengiriman",
            "nama" => auth()->user()->name,
            "pengirimans" => Pengiriman::with(['toko', 'driver'])->latest('updated_at')->get(),
            "data" => collect([
                'toko' => '',
                'tanggalawal' => '',
                'tanggalakhir' => ''
            ])
        ]);
    }

    public function laporanPengirimanSearchCetak(Request $request)
    {
        return view('pengiriman.cetak', [
            "title" => "Pengiriman",
            "nama" => auth()->user()->name,
            "pengirimans" => Pengiriman::with(['toko', 'driver'])
                ->whereBetween('tanggal', [$request["tanggalawal"], $request["tanggalakhir"]])
                ->latest('updated_at')->get(),
            "data" => collect([
                "toko" => $request["toko"],
                "tanggalawal" => $request["tanggalawal"],
                "tanggalakhir" => $request["tanggalakhir"],
            ])
        ]);
    }

    public function laporanDriver()
    {
        return view("driver.laporan", [
            "title" => "Laporan Driver",
            "nama" => auth()->user()->name,
            "drivers" => Driver::select('id', 'nama', 'nik')->get(),
            "pengirimans" => collect([]),
            "data" => collect([
                'clicked' => '',
                "nik" => '',
                'tanggalawal' => '',
                'tanggalakhir' => ''
            ])
        ]);
    }

    public function laporanDriverSearch(Request $request)
    {
        // Driver
        $nikDriver = (explode(" ", $request['driver']));
        $request['driver'] = Driver::where('nik', $nikDriver)->value('nik');

        $request->validate(
            [
                "driver" => "required",
            ],
            [
                "driver.required" => 'Driver Salah / Pilih Driver'
            ]
        );
        $driver = Driver::where('nik', $request['driver'])->get();
        $clicked = $driver[0]['nik'] . ' - ' . $driver[0]['nama'];
        return view("driver.laporan", [
            "title" => "Laporan Driver",
            "nama" => auth()->user()->name,
            "drivers" => Driver::select('id', 'nik', 'nama', 'email', 'no_telepon')->get(),
            "driverSearch" => ($driver)[0],
            "pengirimans" => Pengiriman::with('toko')
                ->where('status', '2')
                ->where('driver_id', $driver[0]['id'])
                ->whereBetween('tanggal', [$request["tanggalawal"], $request["tanggalakhir"]])
                ->get(),
            "data" => collect([
                "clicked" => $clicked,
                "tanggalawal" => $request["tanggalawal"],
                "tanggalakhir" => $request["tanggalakhir"]
            ])
        ]);
    }

    public function laporanDriverSearchCetak(Request $request)
    {
        //Driver

        $request['driver'] = Driver::where('id', $request['idDriver'])->value('id');

        $request->validate(
            [
                "driver" => "required",
            ],
            [
                "driver.required" => 'Driver Salah / Pilih Driver'
            ]
        );
        $driver = Driver::where('id', $request['driver'])->get()[0];
        return view("driver.cetak", [
            "title" => "Laporan Pengiriman ",
            "nama" => auth()->user()->name,
            "driver" => $driver,
            "pengirimans" => Pengiriman::with('toko')
                ->where('status', '2')
                ->where('driver_id', $request['driver'])
                ->whereBetween('tanggal', [$request["tanggalawal"], $request["tanggalakhir"]])
                ->get(),
            "data" => collect([
                "tanggalawal" => $request["tanggalawal"],
                "tanggalakhir" => $request["tanggalakhir"],
            ])
        ]);
    }
}
