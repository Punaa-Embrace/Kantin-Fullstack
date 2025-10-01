<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JakaAja - @yield('title', 'Dashboard')</title>

    @vite('resources/css/app.css')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Custom styles for Tagify to match the project's theme */
        .tagify {
            --tags-border-color: #d1d5db;
            /* ring-gray-300 */
            --tags-focus-border-color: #396C03;
            /* ring-green-600 */
            border: none;
        }

        .tagify__input {
            margin: 0;
            padding: 0.625rem 0.75rem;
            /* Matches py-2.5 px-3 */
        }
    </style>
</head>

<body class="bg-gray-100">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">

        <div x-cloak x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black/50 md:hidden"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        </div>

        <!-- Sidebar -->
        <aside x-cloak :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-30 w-64 px-4 py-7 overflow-y-auto bg-white shadow-lg transition-transform duration-300 ease-in-out md:relative md:translate-x-0 md:shadow-none">
            <!-- Logo -->
            <div class="flex items-center justify-center px-2">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="JakaAja Logo">
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="mt-8">
                <!-- Role-based Navigation -->
                @if (auth()->user()->role === 'student')
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <x-slot name="icon">
                            <x-heroicon-o-home class="w-6 h-6" />
                        </x-slot>
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('student.tenants.index')" :active="request()->routeIs('student.tenants.index')">
                        <x-slot name="icon">
                            <x-heroicon-o-building-storefront class="w-6 h-6" />
                        </x-slot>
                        Daftar Stand
                    </x-nav-link>

                    <x-nav-link :href="route('student.menus.index')" :active="request()->routeIs('student.menus.index')">
                        <x-slot name="icon">
                            <x-heroicon-o-book-open class="w-6 h-6" />
                        </x-slot>
                        Daftar Menu
                    </x-nav-link>

                    <x-nav-link :href="route('student.cart.index')" :active="request()->routeIs('student.cart.index')">
                        <x-slot name="icon">
                            <x-heroicon-o-shopping-cart class="w-6 h-6" />
                        </x-slot>
                        Keranjang Saya
                    </x-nav-link>

                     <x-nav-link :href="route('student.orders.index')" :active="request()->routeIs('student.orders.index')">
                        <x-slot name="icon">
                            <x-heroicon-o-receipt-percent class="w-6 h-6" />
                        </x-slot>
                        Pesanan Saya
                    </x-nav-link>
                @elseif(auth()->user()->role === 'tenant_manager')
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <x-slot name="icon">
                            <x-heroicon-o-building-storefront class="w-6 h-6" />
                        </x-slot>
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('tenant.stand.edit')" :active="request()->routeIs('tenant.stand.*')">
                        <x-slot name="icon">
                           <x-heroicon-o-building-storefront class="w-6 h-6" />
                        </x-slot>
                        Stand
                    </x-nav-link>

                    <x-nav-link :href="route('tenant.orders.index')" :active="request()->routeIs('tenant.orders.*')">
                        <x-slot name="icon">
                            <x-heroicon-o-shopping-bag class="w-6 h-6" />                              
                        </x-slot>
                        Pesanan
                    </x-nav-link>

                    <x-nav-link :href="route('tenant.menu-items.index')" :active="request()->routeIs('tenant.menu-items.*')">
                        <x-slot name="icon">
                            <x-heroicon-o-clipboard-document-list class="w-6 h-6" />
                        </x-slot>
                        Menu
                    </x-nav-link>
                @elseif(auth()->user()->role === 'admin')
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <x-slot name="icon">
                            <x-heroicon-o-chart-pie class="w-6 h-6" />
                        </x-slot>
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                        <x-slot name="icon">
                            <x-heroicon-o-users class="w-6 h-6" />
                        </x-slot>
                        Pengguna
                    </x-nav-link>

                    <x-nav-link :href="route('admin.buildings.index')" :active="request()->routeIs('admin.buildings.*')">
                        <x-slot name="icon">
                            <x-heroicon-o-building-office-2 class="w-6 h-6" />
                        </x-slot>
                        Gedung
                    </x-nav-link>

                    <x-nav-link :href="route('admin.tenants.index')" :active="request()->routeIs('admin.tenants.*')">
                        <x-slot name="icon">
                            <x-heroicon-o-building-storefront class="w-6 h-6" />
                        </x-slot>
                        Stand
                    </x-nav-link>

                    <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                        <x-slot name="icon">
                           <x-heroicon-o-rectangle-stack class="w-6 h-6" />
                        </x-slot>
                        Kategori
                    </x-nav-link>
                @endif
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top bar -->
            <header class="flex justify-between items-center py-4 px-6 bg-gray-100">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none md:hidden">
                    <x-heroicon-o-bars-3 class="h-6 w-6" />
                </button>

                <!-- Page Title -->
                <h1 class="text-xl font-semibold text-gray-700 hidden md:block">@yield('header')</h1>

                <div class="flex items-center space-x-4">
                    <!-- Search Form -->
                    @if(auth()->user()->role === 'student')
                        <form action="{{ route('student.menus.index') }}" method="GET" class="w-32 md:w-48">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            <x-input type="text" name="search" placeholder="Cari..." :value="request('search')">
                                <x-slot name="icon">
                                    <x-heroicon-o-magnifying-glass class="h-5 w-5 text-yellow-500" />
                                </x-slot>
                            </x-input>
                        </form>
                    @endif

                    <!-- Cart Icon for Students -->
                    @if (Auth::user()->role === 'student')
                        <a href="{{ route('student.cart.index') }}"
                            class="relative text-gray-500 hover:text-green-600">
                            <x-heroicon-o-shopping-cart class="w-6 h-6" />
                            <div x-show="$store.cart.totalItems > 0" x-cloak
                                class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center"
                                x-text="$store.cart.totalItems"></div>
                        </a>
                    @endif

                    <!-- Profile Dropdown -->
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen"
                            class="relative z-10 block h-10 w-10 rounded-full overflow-hidden border-2 border-gray-300 focus:outline-none focus:border-green-500">
                            <img class="h-full w-full object-cover"
                                src="{{ auth()->user()->getFirstMediaUrl('profile_photo') ?: 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=d1fae5&color=10b981' }}"
                                alt="Your avatar">
                        </button>

                        <div x-cloak @click.away="dropdownOpen = false" x-show="dropdownOpen" x-transition
                            class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-600 hover:text-white">
                                Pengaturan Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-green-600 hover:text-white">
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

    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>

    @if (session('clear_cart'))
        <div x-data x-init="$store.cart.clear()"></div>
    @endif
</body>

</html>
