<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Pengiriman;
use App\Models\User;
use App\Models\role_user;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use \Barryvdh\DomPDF\Facade\Pdf;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('driver.index', [
            "title" => "Driver",
            "nama" => auth()->user()->name,
            "drivers" => Driver::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('driver.create', [
            "title" => "Driver",
            "nama" => auth()->user()->name,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDriverRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => 'required|numeric|unique:drivers',
            'nama' => 'required|regex:/^[\pL\s\-]+$/u',
            'slug' => 'required',
            'email' => 'required|email|unique:drivers',
            'no_telepon' => 'required|numeric',
            'foto' => 'required|image|file|max:4096'
        ], [
            'nama.alpha' => 'Nama hanya boleh berisikan huruf',
            'nik.numeric' => 'NIK hanya boleh berisikan angka',
            'nik.unique' => 'NIK Telah Terdaftar',
            'email.unique' => 'Email Telah Terdaftar'
        ]);

        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('foto-driver');
        }

        Driver::create($validatedData);

        $user = User::create([
            'name' => $validatedData['nama'],
            'username' => $validatedData['email'],
            'password' => bcrypt('123456'),
            'role_id' => '3'
        ]);
        $user->roles()->attach('3');

        return redirect('/driver')->with('success', 'Data Driver Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
        return view('driver.show', [
            "title" => "Detail Driver",
            "nama" => auth()->user()->name,
            "driver" => $driver
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(Driver $driver)
    {
        return view("driver.edit", [
            "title" => "Ubah Data Driver",
            "nama" => auth()->user()->name,
            "driver" => $driver
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDriverRequest  $request
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Driver $driver)
    {
        $rules = [
            'nik' => 'required|numeric|unique:drivers,nik,' . $driver->id,
            'nama' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email|unique:drivers,email,' . $driver->id,
            'no_telepon' => 'required|numeric'
        ];

        if ($request->slug != $driver->slug) {
            $rules['slug'] = 'required|unique:drivers';
        }

        $validatedData = $request->validate($rules);

        // jika foto diubah
        // cek apakah sudah ada foto di profile
        // tidak : simpan foto yg diupload
        // ya : hapus foto lama kemudian simpan foto yang diupload
        if ($request->file('foto')) {
            if (empty($driver->foto)) {
                $validatedData['foto'] = $request->file('foto')->store('foto-driver');
            } else {
                $validatedData['foto'] = $request->file('foto')->store('foto-driver');
                Storage::delete($driver->foto);
            }
        }
        Driver::where('id', $driver->id)->update($validatedData);

        $pesan = new HtmlString('Data Driver <b>' . ucwords($validatedData['nama']) . '</b> Berhasil diubah!');
        return redirect('/driver')->with('success', $pesan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        if ($driver->foto) {
            Storage::delete($driver->foto);
        }

        $id = User::select('id')->where('username', $driver->email)->value('id');
        role_user::select('user_id')->where('user_id', $id)->delete();
        $driver->delete();
        User::where('username', $driver->email)->delete();

        return redirect('/driver')->with('success', 'Data Driver Berhasil Dihapus!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Driver::class, 'slug', $request->nama);
        return response()->json(['slug' => $slug]);
    }
}
