@extends('layouts.app')

@section('title', 'Mis favoritos')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Mis favoritos</h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @forelse ($favorites as $favorite)
            <div class="bg-white rounded-lg shadow overflow-hidden relative">
                <a href="{{ route('store.product', [$favorite->store_slug, $favorite->product_slug]) }}">
                    <div class="aspect-square bg-gray-200">
                        @if ($favorite->image_url)
                            <img src="{{ $favorite->image_url }}" alt="{{ $favorite->product_name }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="p-3">
                        <h3 class="font-medium text-sm truncate">{{ $favorite->product_name }}</h3>
                        <p class="text-gray-400 text-xs">{{ $favorite->store_name }}</p>
                        <p class="text-indigo-600 font-bold">S/. {{ $favorite->price }}</p>
                    </div>
                </a>
                <form method="POST" action="{{ route('favorites.destroy', $favorite->id) }}" class="absolute top-2 right-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-white rounded-full w-7 h-7 text-red-500 shadow hover:bg-red-50">×</button>
                </form>
            </div>
        @empty
            <p class="text-gray-500 col-span-4">No tienes productos favoritos aún.</p>
        @endforelse
    </div>
@endsection