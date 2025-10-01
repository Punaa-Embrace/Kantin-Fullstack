<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JakaAja - @yield('title')</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-100">
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top bar -->
            <header class="flex justify-between items-center py-4 px-6 bg-white border-b">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="JakaAja Logo">
                </a>

                <!-- Right side of top bar -->
                <div class="flex items-center space-x-4">
                    <!-- Profile Dropdown -->
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 block h-10 w-10 rounded-full overflow-hidden border-2 border-gray-300 focus:outline-none focus:border-green-500">
                            <img class="h-full w-full object-cover" src="{{ auth()->user()->getFirstMediaUrl('profile_photo') ?: 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=d1fae5&color=10b981' }}" alt="Your avatar">
                        </button>
                        <div x-cloak @click.away="dropdownOpen = false" x-show="dropdownOpen" x-transition class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-green-600 hover:text-white">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @yield('content')
            </main>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>
</html>
