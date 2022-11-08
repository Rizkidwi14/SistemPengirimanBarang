<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengiriman;
use App\Models\Toko;
use App\Models\role_user;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek role yg Login
        $id = auth()->user()->id;
        $roles = role_user::where('user_id', $id)->value('role_id');

        // Data Kosong
        $title = '';
        $pengiriman = collect([]);
        $bulan = collect([]);
        $stores = collect([]);
        $chartJumlah[] = '';

        $today = date('Y-m-d');
        $tahun = date('Y');

        // Admin
        if ($roles == 1) {
            $title = 'Pengiriman';
            $pengiriman = Pengiriman::with(['toko', 'driver'])->whereDate('tanggal', $today)->latest('updated_at')->get();
            $jumlahPengirimanHariIni = Pengiriman::whereDate('tanggal', $today)->count();
            $bulan = Pengiriman::select('tanggal')->whereYear('tanggal', 2022)->get();
            for ($i = 1; $i <= 12; $i++) {
                $chartJumlah[$i] = Pengiriman::whereMonth('tanggal', $i)->whereYear('tanggal', $tahun)->count();
            }
            unset($chartJumlah[0]);
            $chartJumlah = array_values($chartJumlah);
        }

        // Store
        if ($roles == 2) {
            $title = 'Store';
            $toko = Toko::where('kode_toko', auth()->user()->name)->value('id');
            $stores = Pengiriman::with(['toko', 'driver'])
                ->where([
                    ['toko_id', $toko],
                    ['tanggal', $today]
                ])->latest('updated_at')->get();
            $jumlahPengirimanHariIni = Pengiriman::whereDate('tanggal', $today)->count();
        }

        // Manajer
        if ($roles == 4) {
            $title = 'Pengiriman';
            $pengiriman = Pengiriman::with(['toko', 'driver'])->whereDate('tanggal', $today)->latest('updated_at')->get();
            $jumlahPengirimanHariIni = Pengiriman::whereDate('tanggal', $today)->count();
            $bulan = Pengiriman::select('tanggal')->whereYear('tanggal', 2022)->get();
            for ($i = 1; $i <= 12; $i++) {
                $chartJumlah[$i] = Pengiriman::whereMonth('tanggal', $i)->whereYear('tanggal', $tahun)->count();
            }
            unset($chartJumlah[0]);
            $chartJumlah = array_values($chartJumlah);
        }

        return view('home', [
            "title" => "$title",
            "nama" => auth()->user()->name,
            "pengirimans" => $pengiriman,
            "bulans" => $bulan,
            "chartPengiriman" => $chartJumlah,
            "stores" => $stores,
            "jumlahPengiriman" => $jumlahPengirimanHariIni,
            "tahun" => $tahun
        ]);
    }
}
