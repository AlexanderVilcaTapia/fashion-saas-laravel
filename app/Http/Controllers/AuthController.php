<?php

namespace App\Http\Controllers;

use App\Services\DjangoApiService;
use Illuminate\Http\Request;

/**
 * Controlador de autenticación.
 * Gestiona el login, registro y logout consumiendo la API Django.
 */
class AuthController extends Controller
{
    protected DjangoApiService $api;

    public function __construct(DjangoApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Procesa el inicio de sesión contra la API Django.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $result = $this->api->login($request->email, $request->password);

        if ($result['success']) {
            return redirect()->route('home')->with('success', 'Sesión iniciada correctamente.');
        }

        return back()->withErrors(['email' => $result['message']])->withInput();
    }

    /**
     * Muestra el formulario de registro.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Procesa el registro de un nuevo usuario comprador.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'username' => 'required|string|max:30',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'password2' => 'required|same:password',
        ]);

        $result = $this->api->register([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'password2' => $request->password2,
        ]);

        if ($result['success']) {
            return redirect()->route('home')->with('success', 'Cuenta creada exitosamente.');
        }

        return back()->withErrors(['email' => $result['message']])->withInput();
    }

    /**
     * Cierra la sesión del usuario.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        $this->api->logout();
        return redirect()->route('home')->with('success', 'Sesión cerrada.');
    }
}