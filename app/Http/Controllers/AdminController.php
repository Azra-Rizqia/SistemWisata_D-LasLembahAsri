<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function loginForm()
    {
        return view('login.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email_admin' => 'required|email',
            'password_admin' => 'required|string|min:8|max:20',
        ], [
            'email_admin.required' => 'Email wajib diisi',
            'email_admin.email' => 'Format email tidak valid',
            'password_admin.required' => 'Password wajib diisi',
            'password_admin.min' => 'Password minimal 8 karakter',
            'password_admin.max' => 'Password maksimal 20 karakter',
        ]);

        $credentials = [
            'email_admin' => $request->email_admin,
            'password'    => $request->password_admin,
        ];

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard.index');
        }

        return back()->withErrors([
            'email_admin' => 'Email atau password salah',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
