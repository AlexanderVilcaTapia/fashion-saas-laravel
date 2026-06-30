@extends('layouts.app')

@section('title', 'Inicio - Fashion SaaS')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Tiendas destacadas</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        @forelse ($stores as $store)
            <a href="{{ route('store.catalog', $store['slug']) }}" class="block bg-white rounded-lg shadow hover:shadow-lg transition p-4">
                @if (!empty($store['logo']))
                    <img src="{{ $store['logo'] }}" alt="{{ $store['name'] }}" class="w-16 h-16 rounded-full object-cover mb-3">
                @endif
                <h2 class="text-lg font-semibold">{{ $store['name'] }}</h2>
                <p class="text-gray-500 text-sm">{{ $store['city'] ?? 'Sin ciudad' }}</p>
                <p class="text-gray-400 text-xs mt-2">{{ $store['total_products'] ?? 0 }} productos</p>
            </a>
        @empty
            <p class="text-gray-500 col-span-3">No hay tiendas disponibles en este momento.</p>
        @endforelse
    </div>

    <h1 class="text-3xl font-bold mb-6">Productos destacados</h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @forelse ($products as $product)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                @php
                    $image = collect($product['images'] ?? [])->firstWhere('is_primary', true)['image'] ?? null;
                @endphp
                <div class="aspect-square bg-gray-200">
                    @if ($image)
                        <img src="{{ $image }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="p-3">
                    <h3 class="font-medium text-sm truncate">{{ $product['name'] }}</h3>
                    <p class="text-indigo-600 font-bold">S/. {{ $product['final_price'] }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-500 col-span-4">No hay productos destacados.</p>
        @endforelse
    </div>
@endsection