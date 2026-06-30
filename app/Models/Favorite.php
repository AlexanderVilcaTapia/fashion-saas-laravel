<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de Favoritos del comprador.
 * Almacena productos marcados como favoritos, vinculados al usuario de Django
 * mediante su ID, ya que la autenticación principal reside en el sistema Django.
 */
class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'django_user_id',
        'product_id',
        'product_name',
        'product_slug',
        'store_slug',
        'store_name',
        'price',
        'image_url',
    ];

    /**
     * Verifica si un producto ya está marcado como favorito por un usuario.
     *
     * @param int $userId  ID del usuario en Django
     * @param int $productId ID del producto en Django
     * @return bool
     */
    public static function isFavorite(int $userId, int $productId): bool
    {
        return self::where('django_user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
    }
}