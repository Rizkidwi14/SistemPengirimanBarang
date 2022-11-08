<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\User;
use App\Models\role_user;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use App\Http\Requests\StoreTokoRequest;
use App\Http\Requests\UpdateTokoRequest;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('toko.index', [
            "title" => "Toko",
            "nama" => auth()->user()->name,
            "tokos" => Toko::withTrashed()->orderBy('kode_toko', 'asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kodeToko = Toko::withTrashed()->max('kode_toko');
        $kodeToko++;
        return view('toko.create', [
            "nama" => auth()->user()->name,
            "kodeToko" => $kodeToko
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTokoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'kode_toko' => 'required|alpha_num|max:4|unique:toko,kode_toko',
                'nama_toko' => 'required',
                'alamat' => 'required',
                'operasional' => 'required',
            ],
            [
                'kode_toko.unique' => 'Kode Toko Telah Terdaftar'
            ]
        );

        $validatedData['status'] = '1';
        $validatedData['kode_toko'] = strtoupper($validatedData['kode_toko']);

        Toko::create($validatedData);

        $user = User::create([
            'name' => $validatedData['kode_toko'],
            'username' => $validatedData['kode_toko'],
            'password' => bcrypt($validatedData['kode_toko']),
            'role_id' => '2'
        ]);
        $user->roles()->attach('2');

        return redirect('/toko')->with('success', 'Data Toko Berhasil Ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Toko  $toko
     * @return \Illuminate\Http\Response
     */
    public function show(Toko $toko)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Toko  $toko
     * @return \Illuminate\Http\Response
     */
    public function edit(Toko $toko)
    {
        return view('toko.edit', [
            "toko" => $toko,
            "nama" => auth()->user()->name,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTokoRequest  $request
     * @param  \App\Models\Toko  $toko
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Toko $toko)
    {
        $rules = [
            'kode_toko' => 'required|alpha_num|max:4|unique:toko,kode_toko,' . $toko->id,
            'nama_toko' => 'required',
            'alamat' => 'required',
            'operasional' => 'required',
            'status' => 'required'
        ];

        $validatedData = $request->validate($rules);
        $validatedData['kode_toko'] = strtoupper($validatedData['kode_toko']);

        Toko::where('id', $toko->id)->update($validatedData);

        $pesan = new HtmlString('Data Toko <b>' . strtoupper($validatedData['kode_toko']) . '</b> Berhasil Diubah!');
        return redirect('/toko')->with('success', $pesan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Toko  $toko
     * @return \Illuminate\Http\Response
     */
    public function destroy(Toko $toko)
    {
        $id = User::select('id')->where('username', $toko->kode_toko)->value('id');
        $toko->forceDelete();
        role_user::select('user_id')->where('user_id', $id)->delete();
        User::where('username', $toko->kode_toko)->delete();
        return redirect('/toko')->with('success', 'Data berhasil dihapus');
    }
}
