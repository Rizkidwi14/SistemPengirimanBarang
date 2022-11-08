<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Toko;
use App\Models\Driver;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use App\Http\Requests\UpdatePengirimanRequest;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Expr\Cast\Unset_;
use PHPUnit\Framework\Constraint\Count;
use Svg\Tag\Rect;

use function PHPUnit\Framework\isNull;

class PengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pengiriman.laporan', [
            "title" => "Pengiriman",
            "nama" => auth()->user()->name,
            "pengirimans" => Pengiriman::with(['toko', 'driver'])->latest('updated_at')->get(),
            "data" => collect([
                'tanggalawal' => '',
                'tanggalakhir' => ''
            ])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengiriman.create', [
            "title" => "Tambah Pengiriman",
            "nama" => auth()->user()->name,
            "tokos" => Toko::orderBy('kode_toko', 'asc')->where('status', 1)->select('id', 'kode_toko', 'nama_toko')->get(),
            "drivers" => Driver::select('id', 'nama', 'nik')->get(),
            "barangs" => Barang::select('kode', 'nama', 'stok')->orderBy('kode')->get(),
            "tokos" => Toko::select('kode_toko', 'nama_toko')->where('status', 1)->get(),
            "data" => collect([
                "driver" => '',
                "no_polisi" => '',
                "kategori" => '',
            ])
        ]);
    }

    public function store(Request $request)
    {
        $nikDriver = explode(" ", $request['driver']);
        $request['driver'] = Driver::where('nik', $nikDriver)->value('nik');

        $kodeToko = explode(" ", $request['toko']);
        $request['toko'] = Toko::where('kode_toko', $kodeToko)->value('kode_toko');

        $request->validate(
            [
                "driver" => "required",
                "toko" => "required",
                "kategori" => "required",
                "no_polisi" => "required"
            ],
            [
                "driver.required" => 'Data Driver Salah / Pilih Driver',
                "toko.required" => 'Data Toko Salah / Pilih Toko'
            ]
        );

        // ID Driver dan Toko
        $idDriver = Driver::where('nik', $nikDriver)->value('id');
        $idToko = Toko::where('kode_toko', $kodeToko)->value('id');

        // cek keaktifan toko
        if (!Toko::where([['kode_toko', $request['toko']], ['status', 1]])->value('status')) {
            return redirect('/pengiriman/create')->with('failed', 'Toko ' . $request['toko'] . ' Tidak Aktif')->withInput();
        }

        // cek jika Tidak ada Barang
        if (!$request['kodeBarang']) {
            return redirect('/pengiriman/create')->with('failed', 'Tidak Ada Barang')->withInput();
        }

        // Validasi Penginputan Barang
        for ($i = 0; $i < count($request['kodeBarang']); $i++) {
            // input kode dan jumlah barang tidak kosong
            if ($request['kodeBarang'][$i] !== null) {

                // Bukan kode Barang yang diinput
                if ($request['kodeBarang'][$i] !== Barang::where('kode', $request['kodeBarang'][$i])->value('kode')) {
                    return redirect('/pengiriman/create')->with('failed', 'Kode Barang ' . $request['kodeBarang'][$i] . ' Salah')->withInput();
                }

                // barang yang dikirim melewati stok yang tersedia
                if ($request['jumlahBarang'][$i] > Barang::where('kode', $request['kodeBarang'][$i])->value('stok')) {
                    return redirect('/pengiriman/create')->with('failed', 'Jumlah ' . $request['kodeBarang'][$i] . ' Melebihi Stok Yang Tersedia')->withInput();
                }

                // Kategori Barang sesuai dengan yang dikirim
                $kategoriBarang = Barang::where('kode', $request['kodeBarang'][$i])->value('kategori');
                if ($kategoriBarang !== $request['kategori']) {
                    return redirect('/pengiriman/create')->with('failed', 'Barang ' . $request['kodeBarang'][$i] . ' Berbeda Dengan Kategori Pengiriman (' . ucwords($request['kategori']) . ')')->withInput();
                }

                // Array Data Barang
                $data[] =
                    [
                        'kodeBarang' => $request['kodeBarang'][$i],
                        'jumlahBarang' => $request['jumlahBarang'][$i]
                    ];
            }
        }

        // Cek Kode Barang Yang Duplikat
        for ($j = 0; $j < count($data); $j++) {
            for ($k = 0; $k <= $j; $k++) {
                if ($j !== $k && $data[$j]['kodeBarang'] == $data[$k]['kodeBarang']) {
                    return redirect('/pengiriman/create')->with('failed', 'Barang ' . $request['kodeBarang'][$j] . ' Duplikat')->withInput();
                }
            }
        }

        // cek apakah sudah ada pengiriman hari ini
        // ada = no_stpb berdasarkan akhir + 1
        // tidak ada = no_stpb pertama hari ini
        $today = date("Y-m-d");
        $pengiriman1 = date("ymd") . "001";
        $tanggalPengiriman = date("ymd");
        $cekPengiriman = DB::table('pengiriman')->where('no_stpb', 'LIKE', $tanggalPengiriman . '%')->get();
        if ($cekPengiriman->isEmpty()) {
            $no_stpb = $pengiriman1;
        } else {
            $no_stpb = Pengiriman::max('no_stpb') + 1;
        }

        $driver = $idDriver;
        $toko = $idToko;
        $tanggal = $today;
        $no_polisi = $request['no_polisi'];
        $kotakPeluru = $request['kotak_peluru'];
        $kategori = $request['kategori'];
        $barang = json_encode($data);

        Pengiriman::create([
            'no_stpb' => $no_stpb,
            'toko_id' => $toko,
            'driver_id' => $driver,
            'tanggal' => $tanggal,
            'kategori' => $kategori,
            'barang' => $barang,
            'no_polisi' => $no_polisi,
            'kotak_peluru' => $kotakPeluru,
            'status' => 0
        ]);

        // kurangi stok
        foreach ($data as $item) {
            $stokBarang = Barang::where('kode', $item['kodeBarang'])->value('stok');
            Barang::where('kode', $item['kodeBarang'])->update([
                "stok" => $stokBarang - $item['jumlahBarang']
            ]);
        }

        return redirect('/pengiriman/create')->with('success', 'Pengiriman Berhasil Ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengiriman  $pengiriman
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengiriman $pengiriman)
    {
        $toko = Toko::select('kode_toko', 'nama_toko')->where('id', $pengiriman->toko_id)->get()[0];
        $driver = Driver::select('nik', 'nama')->where('id', $pengiriman->driver_id)->get()[0];
        return view("pengiriman.edit", [
            "title" => "Ubah Data Pengiriman",
            "nama" => auth()->user()->name,
            "tokos" => Toko::orderBy('kode_toko', 'asc')->select('id', 'kode_toko', 'nama_toko')->where('status', 1)->get(),
            "drivers" => Driver::select('id', 'nik', 'nama', 'email')->get(),
            "barangs" => Barang::select('kode', 'nama', 'stok')->orderBy('kode')->get(),
            "pengiriman" => $pengiriman,
            "toko" => $toko,
            "driver" => $driver
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePengirimanRequest  $request
     * @param  \App\Models\Pengiriman  $pengiriman
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePengirimanRequest $request, Pengiriman $pengiriman)
    {
        $today = date("Y-m-d");
        // Driver
        $nikDriver = (explode(" ", $request['driver']));
        $request['driver'] = Driver::where('nik', $nikDriver)->value('id');

        $kode_toko = (explode(" ", $request['toko']))[0];
        $request['toko'] = Toko::where('kode_toko', $kode_toko)->value('id');

        $request->validate(
            [
                'no_stpb' => 'required',
                'toko' => 'required',
                'no_polisi' => 'required',
                'driver' => 'required',
                'kotak_peluru' => 'required'
            ],
            [
                'toko.required' => 'Kode Toko Salah',
                'driver.required' => 'Driver Salah / Pilih Driver'
            ]
        );

        // cek keaktifan toko
        if (!Toko::where([['kode_toko', $request['toko']], ['status', 1]])->value('status')) {
            return redirect()->back()->with('failed', 'Toko ' . $kode_toko . ' Tidak Aktif')->withInput();
        }

        // cek jika Tidak ada Barang
        if (!$request['kodeBarang']) {
            return redirect()->back()->with('failed', 'Tidak Ada Barang')->withInput();
        }

        // Validasi Penginputan Barang
        for ($i = 0; $i < count($request['kodeBarang']); $i++) {
            // input kode dan jumlah barang tidak kosong
            if ($request['kodeBarang'][$i] !== null) {

                // Bukan kode Barang yang diinput
                if ($request['kodeBarang'][$i] !== Barang::where('kode', $request['kodeBarang'][$i])->value('kode')) {
                    return redirect()->back()->with('failed', 'Kode Barang ' . $request['kodeBarang'][$i] . ' Salah')->withInput();
                }

                // barang yang dikirim melewati stok yang tersedia
                if ($request['jumlahBarang'][$i] > Barang::where('kode', $request['kodeBarang'][$i])->value('stok')) {
                    return redirect()->back()->with('failed', 'Jumlah ' . $request['kodeBarang'][$i] . ' Melebihi Stok Yang Tersedia')->withInput();
                }

                // Kategori Barang sesuai dengan yang dikirim
                $kategoriBarang = Barang::where('kode', $request['kodeBarang'][$i])->value('kategori');
                if ($kategoriBarang !== $request['kategori']) {
                    return redirect()->back()->with('failed', 'Barang ' . $request['kodeBarang'][$i] . ' Berbeda Dengan Kategori Pengiriman')->withInput();
                }

                // Array Data Barang
                $data[] =
                    [
                        'kodeBarang' => $request['kodeBarang'][$i],
                        'jumlahBarang' => $request['jumlahBarang'][$i]
                    ];
            }
        }

        // Cek Kode Barang Yang Duplikat
        for ($j = 0; $j < count($data); $j++) {
            for ($k = 0; $k <= $j; $k++) {
                if ($j !== $k && $data[$j]['kodeBarang'] == $data[$k]['kodeBarang']) {
                    return redirect()->back()->with('failed', 'Barang ' . $request['kodeBarang'][$j] . ' Duplikat')->withInput();
                }
            }
        }


        // update data pengiriman
        Pengiriman::where('id', $pengiriman->id)->update([
            "no_stpb" => $request['no_stpb'],
            "toko_id" => $request['toko'],
            'no_polisi' => $request['no_polisi'],
            "driver_id" => $request['driver'],
            "tanggal" => $today,
            "status" => 0,
            "kotak_peluru" => $request['kotak_peluru']
        ]);


        // pengubahan stok barang
        foreach (json_decode($pengiriman->barang, true)  as $row) {
            $stok = Barang::where('kode', $row['kodeBarang'])->value('stok');
            Barang::where('kode', $row['kodeBarang'])->update([
                'stok' => $stok + $row['jumlahBarang']
            ]);
        }

        foreach ($data as $item) {
            $stokBarang = Barang::where('kode', $item['kodeBarang'])->value('stok');
            Barang::where('kode', $item['kodeBarang'])->update([
                "stok" => $stokBarang - $item['jumlahBarang']
            ]);
        }

        // update data barang pengiriman
        $pengiriman->update(['barang' => json_encode($data)]); //eloquent 'update' ganti json jadi array

        $pesan = new HtmlString('Pengiriman <b>' . ucwords($pengiriman->no_stpb) . '</b> Berhasil diubah!');
        return redirect('/pengiriman/pickup')->with('success', $pesan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengiriman  $pengiriman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengiriman $pengiriman)
    {
        foreach (json_decode($pengiriman->barang, true)  as $row) {
            $stok = Barang::where('kode', $row['kodeBarang'])->value('stok');
            Barang::where('kode', $row['kodeBarang'])->update([
                'stok' => $stok + $row['jumlahBarang']
            ]);
        }
        Pengiriman::destroy($pengiriman->id);
        return redirect('/pengiriman/pickup')->with('success', 'Data berhasil dihapus');
    }


    public function indexPickup()
    {
        return view('pengiriman.pickup', [
            "title" => "Pickup Pengiriman",
            "nama" => auth()->user()->name,
            "pengirimans" => Pengiriman::with(['toko', 'driver'])->where('status', 0)->latest('no_stpb')->get()
        ]);
    }

    public function pickup(Pengiriman $pengiriman)
    {
        $waktu_kirim = date("H:i:s");
        Pengiriman::where('no_stpb', $pengiriman->no_stpb)
            ->update([
                'status' => 1,
                'waktu_kirim' => $waktu_kirim
            ]);

        $pesan = new HtmlString('Pickup <b>' . strtoupper($pengiriman->no_stpb) . '</b> Berhasil!');
        return redirect('/pengiriman/pickup')->with('success', $pesan);
    }
}
