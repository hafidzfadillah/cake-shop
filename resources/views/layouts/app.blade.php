<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Shop - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div>
                    <a href="/" class="text-xl font-bold">Cake Shop</a>
                </div>
                <div class="flex space-x-4">
                    @auth
                        <a href="/cart" class="text-gray-700">Cart</a>
                        <a href="/transactions" class="text-gray-700">Orders</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700">Login</a>
                        <a href="{{ route('register') }}" class="text-gray-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto mt-6 px-4">
        @include('components.flash-message')
        @yield('content')
    </main>

    <footer class="bg-white shadow-lg bottom-0 z-50 mt-10">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div>
                    <p class="text-gray-700">© 2024 Cake Shop</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
