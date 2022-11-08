<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTokoRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UpdatePasswordController extends Controller
{
    public function index()
    {
        return view('password.index', [
            "title" => "Ganti Password",
            "nama" => auth()->user()->name
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password' => 'required|min:4|confirmed'
        ]);

        if (Hash::check($request->password_lama, auth()->user()->password)) {
            User::where('id', auth()->user()->id)
                ->update(['password' => bcrypt($request->password)]);
            return back()->with('success', 'Password Berhasil Diganti');
        } else {
            throw ValidationException::withMessages([
                'password_lama' => 'Password Lama Salah'
            ]);
        }
    }
}
