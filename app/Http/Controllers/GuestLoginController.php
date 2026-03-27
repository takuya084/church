<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GuestLoginController extends Controller
{
    public function login()
    {
        $guest = User::where('email', 'guest@ichihara-church.local')->first();

        if (!$guest) {
            return redirect()->route('login')->withErrors(['email' => 'ゲストアカウントが見つかりません。']);
        }

        Auth::login($guest);
        Session::regenerate();

        return redirect()->route('dashboard');
    }
}
