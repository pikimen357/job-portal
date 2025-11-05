<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('email',
            'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('about');
        }
        return back()->withErrors(['email' => 'Email atau
                        password salah.']);
    }

    public function showRegisterForm(){
        return view('auth.register');
    }

    public function register (Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            ]
        );

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'job_seeker',
            ]);

        return redirect()->route('login')->with('success',
                    'Registrasi berhasil! Silakan login.');
    }
    public function logout(){
        Auth::logout();

        return redirect()->route('login');
    }

    public function profile(){
        $user = Auth::user();

        return view('auth.profile', compact('user'));
    }

    public function about(){
        $user = Auth::user();
        return view('about', compact('user'));
    }
}
