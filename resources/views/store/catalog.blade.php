@extends('layouts.app')

@section('title', $store['name'] ?? 'Catálogo')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold">{{ $store['name'] }}</h1>
        <p class="text-gray-500">{{ $store['description'] ?? '' }}</p>
        <p class="text-gray-400 text-sm">{{ $store['city'] ?? '' }} — {{ $store['address'] ?? '' }}</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @forelse ($products as $product)
            <a href="{{ route('store.product', [$store['slug'], $product['slug']]) }}"
               class="block bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
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
            </a>
        @empty
            <p class="text-gray-500 col-span-4">No hay productos en esta tienda.</p>
        @endforelse
    </div>
@endsection