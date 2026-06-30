<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('django_user_id')->comment('ID del usuario en el sistema Django');
            $table->unsignedBigInteger('product_id')->comment('ID del producto en Django');
            $table->string('product_name');
            $table->string('product_slug');
            $table->string('store_slug');
            $table->string('store_name');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();

            $table->unique(['django_user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
