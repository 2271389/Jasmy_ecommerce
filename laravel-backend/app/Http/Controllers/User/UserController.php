<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function User()
    {

        return Auth::user();
    } // End Mehtod
    public function login()
    {
        return view('users.login', [
            'title' => 'Đăng nhập',
        ]);
    }
}
