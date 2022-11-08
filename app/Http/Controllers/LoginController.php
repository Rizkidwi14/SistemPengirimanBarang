<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\role_user;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Masukkan Username',
            'password.required' => 'Masukkan Password'
        ]);

        if (Auth::attempt($credentials)) {
            // $id = User::select('id')->where('username', $credentials['username'])->value('id');
            // $role = role_user::select('role_id')->where('user_id', $id)->value('role_id');
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        return back()->with('loginError', 'Username atau Password Salah!');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    }
}
