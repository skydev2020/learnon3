<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        if (Auth::check())
        {
            $user = Auth::User();
            if ($user->hasRole('Admin')) return redirect()->route('admin.home');
            return redirect()->route('home');
        }
        return redirect()->route('login');
    }
}
