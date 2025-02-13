<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bites of Bliss - Cake Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/" class="text-base font-bold flex items-center">
                    <img src="{{ asset('assets/logo.png') }}" alt="Bites of Bliss Logo" class="h-20 w-auto mr-2">
                    Bites of Bliss
                </a>

                <!-- Navigation -->
                <div class="hidden md:flex space-x-6">

                </div>
                <!-- User Actions -->
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

    <!-- Product Section -->
    <!-- <main class="max-w-6xl mx-auto mt-6 px-4"> -->
    <main>
        @include('components.flash-message')
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-md mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <p class="text-gray-600 text-sm">© 2024 Bites of Bliss</p>
                <a href="#" class="text-gray-700 hover:text-gray-900">Privacy Policy</a>
            </div>
        </div>
    </footer>
</body>
</html>
