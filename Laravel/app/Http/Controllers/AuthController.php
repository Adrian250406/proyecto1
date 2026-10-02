<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Muestra la pantalla con el formulario de login
    public function showLoginForm()
    {
        // Si ya está logueado, lo mandamos directo al panel de admin
        if (Auth::check()) {
            return redirect()->route('admin.reservas.index');
        }
        return view('auth.login');
    }

    // 2. Procesa el correo y la contraseña ingresados
    public function login(Request $request)
    {
        // Validamos que no envíen campos vacíos
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debes ingresar un correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Intentamos iniciar sesión con Auth::attempt
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.reservas.index'))
                ->with('success', '¡Bienvenido al Panel Administrativo!');
        }

        // Si la clave no coincide, regresamos con error
        return back()->withErrors([
            'email' => 'El correo o la contraseña son incorrectos.',
        ])->onlyInput('email');
    }

    // 3. Cierra la sesión de forma segura
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Sesión cerrada correctamente.');
    }
}
