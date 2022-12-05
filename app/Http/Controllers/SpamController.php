<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengiriman;
use App\Models\Toko;


class SpamController extends Controller
{
    public function index()
    {

        // dd(action([PengirimanController::class, 'index']));
        $kodeToko = Toko::max('kode_toko');
        $kodeToko++;
        for ($i = 1; $i <= 12; $i++) {
            $jumlah[] = Pengiriman::whereMonth('tanggal', $i)->count();
        }
        return view('spam', [
            "title" => "Pengiriman",
            "nama" => auth()->user()->name,
            "pengirimans" => Pengiriman::with(['toko', 'driver'])->latest('updated_at')->get(),
            "bulans" => Pengiriman::select('tanggal')->whereYear('tanggal', 2022)->get(),
            "jumlahPengiriman" => $jumlah,
            "kodeToko" => $kodeToko
        ]);
    }
}
