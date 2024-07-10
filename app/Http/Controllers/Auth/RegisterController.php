<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Pastikan Anda mengimpor model User dengan namespace yang benar
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Menampilkan form registrasi
    public function index()
    {
        return view('auth.register');
    }

    // Metode untuk memproses registrasi
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Membuat pengguna baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke halaman login setelah registrasi
        return redirect()->route('login.index')->with('success', 'Registration successful. Please login.');
    }
}
