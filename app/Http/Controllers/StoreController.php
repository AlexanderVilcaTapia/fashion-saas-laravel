<?php

namespace App\Http\Controllers;

use App\Services\DjangoApiService;

/**
 * Controlador de tiendas y catálogo de productos.
 * Consume la API Django para mostrar tiendas y productos al comprador.
 */
class StoreController extends Controller
{
    protected DjangoApiService $api;

    public function __construct(DjangoApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Muestra la página principal con tiendas y productos destacados.
     */
    public function home()
    {
        $stores = $this->api->getFeaturedStores();
        $products = $this->api->getFeaturedProducts();

        return view('home', compact('stores', 'products'));
    }

    /**
     * Muestra el catálogo de productos de una tienda específica.
     *
     * @param string $storeSlug
     */
    public function catalog(string $storeSlug)
    {
        $store = $this->api->getStoreBySlug($storeSlug);
        $products = $this->api->getStoreProducts($storeSlug);

        if (!$store) {
            abort(404, 'Tienda no encontrada.');
        }

        return view('store.catalog', compact('store', 'products'));
    }

    /**
     * Muestra el detalle de un producto específico.
     *
     * @param string $storeSlug
     * @param string $productSlug
     */
    public function productDetail(string $storeSlug, string $productSlug)
    {
        $product = $this->api->getProductDetail($storeSlug, $productSlug);

        if (!$product) {
            abort(404, 'Producto no encontrado.');
        }

        return view('store.product', compact('product'));
    }
}