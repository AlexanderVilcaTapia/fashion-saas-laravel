<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Services\DjangoApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Controlador de Favoritos.
 * Gestiona el CRUD de productos favoritos almacenados en MySQL local,
 * vinculados al usuario autenticado en el sistema Django.
 */
class FavoriteController extends Controller
{
    protected DjangoApiService $api;

    public function __construct(DjangoApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Muestra la lista de favoritos del usuario autenticado.
     */
    public function index()
    {
        if (!$this->api->isAuthenticated()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver tus favoritos.');
        }

        $userId = Session::get('django_user_id');
        $favorites = Favorite::where('django_user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Agrega un producto a favoritos.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!$this->api->isAuthenticated()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para agregar favoritos.');
        }

        $userId = Session::get('django_user_id');

        Favorite::firstOrCreate(
            [
                'django_user_id' => $userId,
                'product_id' => $request->product_id,
            ],
            [
                'product_name' => $request->product_name,
                'product_slug' => $request->product_slug,
                'store_slug' => $request->store_slug,
                'store_name' => $request->store_name,
                'price' => $request->price,
                'image_url' => $request->image_url,
            ]
        );

        return back()->with('success', 'Producto agregado a favoritos.');
    }

    /**
     * Elimina un producto de favoritos.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $userId = Session::get('django_user_id');
        Favorite::where('id', $id)->where('django_user_id', $userId)->delete();

        return back()->with('success', 'Producto eliminado de favoritos.');
    }
}