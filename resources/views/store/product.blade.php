@extends('layouts.app')

@section('title', $product['name'] ?? 'Producto')

@section('content')
    <div class="grid md:grid-cols-2 gap-10 bg-white rounded-lg shadow p-6">
        <div class="aspect-square bg-gray-200 rounded-lg overflow-hidden">
            @php
                $image = collect($product['images'] ?? [])->firstWhere('is_primary', true)['image'] ?? null;
            @endphp
            @if ($image)
                <img src="{{ $image }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover">
            @endif
        </div>

        <div>
            <p class="text-gray-400 text-sm">{{ $product['store_name'] ?? '' }}</p>
            <h1 class="text-2xl font-bold mb-2">{{ $product['name'] }}</h1>

            <div class="flex items-center gap-3 mb-4">
                <span class="text-2xl font-bold text-indigo-600">S/. {{ $product['final_price'] }}</span>
                @if ($product['has_discount'] ?? false)
                    <span class="text-gray-400 line-through">S/. {{ $product['price'] }}</span>
                @endif
            </div>

            <p class="text-gray-600 mb-6">{{ $product['description'] ?? '' }}</p>

            <h3 class="font-semibold mb-2">Tallas disponibles</h3>
            <div class="flex gap-2 mb-6">
                @forelse ($product['sizes'] ?? [] as $size)
                    <span class="border rounded px-3 py-1 text-sm {{ $size['stock'] == 0 ? 'text-gray-300 line-through' : '' }}">
                        {{ $size['size'] }}
                    </span>
                @empty
                    <p class="text-gray-400 text-sm">Sin tallas disponibles.</p>
                @endforelse
            </div>

            <p class="text-sm text-gray-400">
                Para comprar este producto, usa la app móvil o la web de Fashion SaaS.
            </p>
        </div>
    </div>
@endsection