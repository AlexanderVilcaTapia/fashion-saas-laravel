<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fashion SaaS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <nav class="bg-indigo-600 text-white px-6 py-4 flex justify-between items-center shadow">
        <a href="{{ route('home') }}" class="text-xl font-bold">Fashion SaaS</a>
        <div class="flex gap-4 items-center">
            <a href="{{ route('orders.index') }}" class="hover:underline">Mis órdenes</a>
            <a href="{{ route('favorites.index') }}" class="hover:underline">Favoritos</a>
            <a href="{{ route('login') }}" class="hover:underline">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-4 py-1 rounded font-semibold hover:bg-gray-100">Registrarse</a>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-8">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>