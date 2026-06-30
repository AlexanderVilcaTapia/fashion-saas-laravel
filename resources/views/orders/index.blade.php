@extends('layouts.app')

@section('title', 'Mis órdenes')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Mis órdenes</h1>

    <div class="space-y-4">
        @forelse ($orders['results'] ?? [] as $order)
            <div class="bg-white rounded-lg shadow p-5">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h2 class="font-semibold">Orden #{{ $order['id'] }}</h2>
                        <p class="text-gray-500 text-sm">{{ $order['store_name'] }}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded bg-indigo-100 text-indigo-700">
                        {{ ucfirst($order['status']) }}
                    </span>
                </div>
                <p class="text-gray-400 text-xs">{{ \Carbon\Carbon::parse($order['created_at'])->format('d/m/Y') }}</p>
                <p class="font-bold text-indigo-600 mt-2">S/. {{ $order['total'] }}</p>
            </div>
        @empty
            <p class="text-gray-500">No tienes órdenes aún.</p>
        @endforelse
    </div>
@endsection