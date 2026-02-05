<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostra a view do formulário de login.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Gere uma tentativa de autenticação.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->role_id==1) {
                return redirect()->intended('dashboard-admin');
               
            }
            if (Auth::user()->role_id==2) {
               
                return redirect()->intended('dashboard-director');
            }

            if (Auth::user()->role_id==3) {
               
                return redirect()->intended('dashboard-avaliador');
            }

            if (Auth::user()->role_id==4) {
               
                return redirect()->intended('dashboard-autor');
            }

        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registos.',
        ])->onlyInput('email');
    }

    /**
     * Destrói uma sessão autenticada (logout).
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}