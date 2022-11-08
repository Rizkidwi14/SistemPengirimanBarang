<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\role_user;


class RoleController extends Controller
{
    public function index(role_user $role)
    {
        dd($role);
        $id = auth()->user()->id;
        $roles = role_user::where('user_id', $id)->value('role_id');
        if ($id == $roles) {
            echo 'benar';
        } else {
            echo 'salah';
        }
    }
}
