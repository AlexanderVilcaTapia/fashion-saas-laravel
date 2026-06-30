<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

/**
 * Servicio que centraliza todas las llamadas HTTP a la API REST de Django.
 * Maneja la autenticación JWT y la comunicación con el backend principal.
 */
class DjangoApiService
{
    /** URL base de la API Django, leída desde el archivo .env */
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.django.url');
    }

    /**
     * Construye el cliente HTTP con el token JWT si el usuario está autenticado.
     *
     * @return \Illuminate\Http\Client\PendingRequest
     */
    protected function client()
    {
        $token = Session::get('access_token');
        $http = Http::baseUrl($this->baseUrl)->acceptJson();

        if ($token) {
            $http = $http->withToken($token);
        }

        return $http;
    }

    /**
     * Inicia sesión contra la API Django y guarda los tokens en la sesión.
     *
     * @param string $email
     * @param string $password
     * @return array Resultado con éxito y datos o mensaje de error
     */
    public function login(string $email, string $password): array
    {
        $response = Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->post('/auth/login/', [
                'email' => $email,
                'password' => $password,
            ]);

        if ($response->successful()) {
            $data = $response->json();
            Session::put('access_token', $data['access']);
            Session::put('refresh_token', $data['refresh']);
            return ['success' => true, 'data' => $data];
        }

        return ['success' => false, 'message' => 'Credenciales incorrectas.'];
    }

    /**
     * Registra un nuevo usuario comprador en la API Django.
     *
     * @param array $data Datos del formulario de registro
     * @return array Resultado con éxito y datos o mensaje de error
     */
    public function register(array $data): array
    {
        $response = Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->post('/auth/register/', $data);

        if ($response->successful()) {
            $result = $response->json();
            Session::put('access_token', $result['tokens']['access']);
            Session::put('refresh_token', $result['tokens']['refresh']);
            return ['success' => true, 'data' => $result];
        }

        return ['success' => false, 'message' => 'Error al registrarse. Verifica los datos.'];
    }

    /**
     * Cierra la sesión local eliminando los tokens guardados.
     */
    public function logout(): void
    {
        Session::forget('access_token');
        Session::forget('refresh_token');
    }

    /**
     * Verifica si el usuario tiene una sesión activa.
     *
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return Session::has('access_token');
    }

    /**
     * Obtiene los datos del usuario autenticado.
     *
     * @return array|null
     */
    public function getCurrentUser(): ?array
    {
        $response = $this->client()->get('/auth/me/');
        return $response->successful() ? $response->json() : null;
    }

    /**
     * Obtiene las tiendas destacadas para la página principal.
     *
     * @return array
     */
    public function getFeaturedStores(): array
    {
        $response = $this->client()->get('/stores/featured/');
        return $response->successful() ? $response->json() : [];
    }

    /**
     * Obtiene los productos destacados para la página principal.
     *
     * @return array
     */
    public function getFeaturedProducts(): array
    {
        $response = $this->client()->get('/products/featured/');
        return $response->successful() ? $response->json() : [];
    }

    /**
     * Obtiene los productos de una tienda específica por su slug.
     *
     * @param string $storeSlug
     * @return array
     */
    public function getStoreProducts(string $storeSlug): array
    {
        $response = $this->client()->get("/stores/{$storeSlug}/products/");
        return $response->successful() ? $response->json() : [];
    }

    /**
     * Obtiene el detalle de una tienda por su slug.
     *
     * @param string $storeSlug
     * @return array|null
     */
    public function getStoreBySlug(string $storeSlug): ?array
    {
        $response = $this->client()->get("/stores/{$storeSlug}/");
        return $response->successful() ? $response->json() : null;
    }

    /**
     * Obtiene el detalle de un producto específico.
     *
     * @param string $storeSlug
     * @param string $productSlug
     * @return array|null
     */
    public function getProductDetail(string $storeSlug, string $productSlug): ?array
    {
        $response = $this->client()->get("/products/{$storeSlug}/{$productSlug}/");
        return $response->successful() ? $response->json() : null;
    }

    /**
     * Obtiene el historial de órdenes del usuario autenticado.
     *
     * @return array
     */
    public function getOrders(): array
    {
        $response = $this->client()->get('/orders/');
        return $response->successful() ? $response->json() : ['results' => []];
    }
}