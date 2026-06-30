@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Iniciar sesión</h1>

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="ej: alexander@email.com"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Contraseña</label>
                <input type="password" name="password"
                       placeholder="Tu contraseña"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded font-semibold hover:bg-indigo-700">
                Iniciar sesión
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-4">
            ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Regístrate</a>
        </p>
    </div>
@endsection