<?php

namespace App\Http\Controllers;

use App\Services\DjangoApiService;
use Illuminate\Support\Facades\Redirect;

/**
 * Controlador del historial de órdenes del comprador.
 */
class OrderController extends Controller
{
    protected DjangoApiService $api;

    public function __construct(DjangoApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Muestra el historial de órdenes del usuario autenticado.
     * Redirige al login si no hay sesión activa.
     */
    public function index()
    {
        if (!$this->api->isAuthenticated()) {
            return Redirect::route('login')->with('error', 'Debes iniciar sesión para ver tus órdenes.');
        }

        $orders = $this->api->getOrders();

        return view('orders.index', compact('orders'));
    }
}