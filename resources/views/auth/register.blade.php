@extends('layouts.app')

@section('title', 'Crear cuenta')

@section('content')
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Crear cuenta</h1>

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}"
                           placeholder="ej: Alexander"
                           class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Apellido</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}"
                           placeholder="ej: Vilca"
                           class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Usuario</label>
                <input type="text" name="username" value="{{ old('username') }}"
                       placeholder="ej: alexander123 (sin espacios)"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="ej: alexander@email.com"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-1">Contraseña</label>
                    <input type="password" name="password"
                           placeholder="Mínimo 8 caracteres"
                           class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Confirmar</label>
                    <input type="password" name="password2"
                           placeholder="Repite tu contraseña"
                           class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded font-semibold hover:bg-indigo-700">
                Crear cuenta
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-4">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Inicia sesión</a>
        </p>
    </div>
@endsection