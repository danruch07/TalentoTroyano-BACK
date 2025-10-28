<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister() { return view('auth.register'); }
    public function showLogin()    { return view('auth.login'); }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'full_name' => $request->full_name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'role'      => $request->role, // student o company
            'password'  => Hash::make($request->password),
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended('/')->with('success','Cuenta creada correctamente.');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email','password');

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success','Bienvenido/a.');
        }

        return back()->withErrors(['email'=>'Credenciales inválidas'])->onlyInput('email');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login')->with('success','Sesión cerrada.');
    }
}
