<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JakaAja - Web Kantin Polibatam</title>

    {{-- Vite CSS & JS --}}
    @vite('resources/css/app.css')

    {{-- Alpine.js for interactivity --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Google Fonts: Poppins and Nunito (used in the design) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Nunito:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* Custom font family for sections that need Nunito */
        .font-nunito {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body class="bg-white font-sans text-gray-800 antialiased">


    <header x-data="{ mobileMenuOpen: false }" class="absolute w-full top-0  z-50 ">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8 bg-white md:bg-transparent">
            <div class="flex items-center justify-between h-20">

                <div class="flex-shrink-0">
                    <a href="#" class="flex items-center">
                        <img class="h-10 w-auto" src="{{ asset('images/logo.png') }}" alt="JakaAja Logo">
                    </a>
                </div>


                <div class="hidden md:flex md:items-center md:space-x-8 ml-10 bg-white md:bg-transparent">
                    <a href="#hero" class="text-gray-800 hover:text-green-600 transition-colors">Home</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-green-600 transition-colors">Cara Kerja</a>
                    <a href="#locations" class="text-gray-600 hover:text-green-600 transition-colors">Lokasi Kantin</a>
                    <a href="#team" class="text-gray-600 hover:text-green-600 transition-colors">Tentang Kami</a>
                </div>


                <div class="flex-grow"></div>


                <div class="hidden md:flex items-center space-x-3 ml-auto">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-gray-800 border border-gray-200 rounded-full hover:bg-gray-100 transition-colors shadow-sm">
                            <img class="h-8 w-8 rounded-full object-cover"
                                src="{{ auth()->user()->getFirstMediaUrl('profile_photo') ?: 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=d1fae5&color=10b981' }}"
                                alt="{{ auth()->user()->name }}">
                            <span>Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-5 py-2 text-sm font-medium text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-5 py-2 text-sm font-medium text-white bg-gray-800 rounded-lg hover:bg-gray-900 transition-colors">
                            Buat Akun
                        </a>
                    @endauth
                </div>


                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                        <x-heroicon-o-bars-3 x-show="!mobileMenuOpen" class="w-6 h-6" />
                        <x-heroicon-o-x-mark x-show="mobileMenuOpen" class="w-6 h-6" x-cloak />
                    </button>
                </div>
            </div>
        </nav>


        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white shadow-lg">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#hero"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-800 hover:bg-gray-100">Home</a>
                <a href="#how-it-works"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-100">Cara
                    Kerja</a>
                <a href="#locations"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-100">Lokasi
                    Kantin</a>
                <a href="#team"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-100">Tentang
                    Kami</a>
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <div class="px-3">
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center gap-3 p-2 -mx-2 rounded-lg hover:bg-gray-100">
                                <img class="h-10 w-10 rounded-full object-cover"
                                    src="{{ auth()->user()->getFirstMediaUrl('profile_photo') ?: 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=d1fae5&color=10b981' }}"
                                    alt="{{ auth()->user()->name }}">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                    <p class="text-sm text-gray-600">Lihat Dashboard</p>
                                </div>
                            </a>
                        @else
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('login') }}"
                                    class="flex-1 text-center px-4 py-2 text-sm font-medium text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-100">Masuk</a>
                                <a href="{{ route('register') }}"
                                    class="flex-1 text-center px-4 py-2 text-sm font-medium text-white bg-gray-800 rounded-lg hover:bg-gray-900">Buat
                                    Akun</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>

        <section id="hero" class="relative overflow-hidden h-screen flex items-center">

            <div class="absolute left-2 top-20 w-28 z-10">
                <img src="{{ asset('images/landing/left-image.png') }}" alt="Background Left" class="object-contain">
            </div>
            <div class="absolute -bottom-40 -right-40 w-[500px] opacity-20 md:w-auto md:h-full md:top-0 md:right-0 md:bottom-auto md:opacity-100">
                <img src="{{ asset('images/landing/right-image.png') }}" alt="Background Right" class="h-full object-cover">
            </div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

                    <div class="text-center md:text-left">
                        <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 leading-tight">
                            Selamat Datang<br>Di <span class="text-green-600">JakaAja!</span>
                        </h1>
                        <p class="mt-6 text-lg text-gray-600 max-w-xl mx-auto md:mx-0">
                            Pesan makanan favoritmu dari kantin Politeknik Negeri Batam dengan mudah, cepat, dan tanpa
                            antre.
                        </p>
                        <div class="mt-10">
                            <a href="{{ route('register') }}"
                                class="inline-block bg-green-600 text-white font-bold text-lg px-8 py-4 rounded-xl hover:bg-green-700 transition-transform hover:scale-105">
                                Pesan Sekarang
                            </a>
                        </div>
                    </div>

                    <div class="hidden lg:block">

                    </div>
                </div>
            </div>
        </section>



        <section id="features" class="py-20 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-base font-semibold text-green-600 tracking-wide uppercase">Kenapa Memilih Belanja di
                        JakaAja?</h2>
                    <p class="mt-2 text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Keunggulan Belanja
                        di Aplikasi JakaAja</p>
                </div>
                <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">

                    <div class="bg-white p-8 rounded-2xl shadow-lg text-center flex flex-col items-center">
                        <div
                            class="flex-shrink-0 h-16 w-16 flex items-center justify-center bg-green-100 text-green-600 rounded-full">
                            <x-heroicon-o-book-open class="w-8 h-8"/>
                        </div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">Menu Harian Kantin</h3>
                        <p class="mt-2 text-gray-600">Kamu dapat melihat jenis makanan atau minuman apa saja yang
                            tersedia di kantin Polibatam</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-lg text-center flex flex-col items-center">
                        <div
                            class="flex-shrink-0 h-16 w-16 flex items-center justify-center bg-green-100 text-green-600 rounded-full">
                            <x-heroicon-o-credit-card class="w-8 h-8"/>
                        </div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">Pesan Makan</h3>
                        <p class="mt-2 text-gray-600">JakaAja Menyediakan Pesananan secara online tanpa harus datang ke
                            kantin</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-lg text-center flex flex-col items-center">
                        <div
                            class="flex-shrink-0 h-16 w-16 flex items-center justify-center bg-green-100 text-green-600 rounded-full">
                            <x-heroicon-o-qr-code class="w-8 h-8"/>
                        </div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">Pembayaran Mudah</h3>
                        <p class="mt-2 text-gray-600">Kamu dapat memilih bayar pesanan menggunakan via QRIS atau Tunai
                        </p>
                    </div>
                </div>
            </div>
        </section>


        <section id="how-it-works" class="py-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Bagaimana Pesan di
                        JakaAja?</h2>
                </div>


                <img src="{{ asset('images/landing/how-to-order.png') }}" alt="Cara Pemesanan" class="w-full mb-4">
            </div>

        </section>


        <section id="menu" class="py-20 bg-gray-50 font-nunito">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">Rekomendasi Menu Hari
                        Ini</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    @foreach ($recommendedMenus as $menu)
                        <div
                            class="bg-white rounded-2xl shadow overflow-hidden pb-5 transform hover:-translate-y-2 transition-transform duration-300">
                            <img src="{{ $menu->getFirstMediaUrl('menu_item_photo') ?: asset('images/no-img.jpg') }}" alt="{{ $menu->name }}"  alt="{{ $menu['name'] }}" class="w-full aspect-square object-cover">
                            <div class="px-5 mt-6 flex flex-col gap-6">
                                <div class="flex justify-between items-center">
                                    <div class="text-black text-lg font-medium leading-tight">{{ $menu['name'] }}
                                    </div>
                                    <a href="{{ route('login') }}"
                                        class="px-4 py-1 bg-red-600 rounded-full text-white text-center text-sm font-medium">
                                        Beli Sekarang
                                    </a>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="flex gap-1">
                                        @for ($i = 0; $i < $menu['rating']; $i++)
                                            <x-heroicon-s-star class="w-4 h-4 text-yellow-500" />
                                        @endfor
                                    </div>
                                    <div class="text-black text-2xl font-bold">
                                        RP. {{ $menu['price'] }}
                                    </div>
                                </div>
                                <div class="text-sm font-semibold text-green-600">{{ $menu->tenant->name}}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        <section id="locations" class="py-20 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Lokasi Kantin
                        Polibatam</h2>
                    <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                        Di Politeknik Batam hanya 2 gedung yang memiliki kantin yaitu Gedung Utama dan Gedung RTF
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">

                    <div class="overflow-hidden transform transition-transform hover:-translate-y-2 duration-300">
                        <img src="{{ asset('images/landing/building-main.png') }}" alt="Kantin Gedung Utama"
                            class="w-full object-cover rounded-xl ">
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-gray-800">Gedung Utama</h3>
                        </div>
                    </div>


                    <div class="overflow-hidden transform transition-transform hover:-translate-y-2 duration-300">
                        <img src="{{ asset('images/landing/building-rtf.png') }}" alt="Kantin Gedung RTF"
                            class="w-full object-cover rounded-xl">
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-gray-800">Gedung RTF</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <section id="team" class="py-20 relative">

            <div class="absolute inset-0 bg-cover bg-center h-1/2 bottom-0"
                style="background-image: url('{{ asset('images/landing/member-bg.png') }}')"></div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white">Team Member</h2>
                    <p class="mt-4 max-w-2xl mx-auto text-lg text-white">Orang-orang hebat di balik JakaAja.</p>
                </div>

                @php
                    $team = [
                        [
                            'name' => 'Jhon Martin Gabriel Sirait',
                            'role' => 'Backend',
                            'image' => asset("images/landing/members/jhon.png"),
                        ],
                        [
                            'name' => 'Kharlos Daylo Saut Silaban',
                            'role' => 'Fond End Developer',
                            'image' => asset("images/landing/members/kharlos.png"),
                        ],
                        [
                            'name' => 'Rahel Hadasa Friskila Ginting',
                            'role' => 'Fond End Developer',
                            'image' => asset("images/landing/members/rahel.png"),
                        ],
                        [
                            'name' => 'Winda Marenta Nainggolan',
                            'role' => 'Founder',
                            'image' => asset("images/landing/members/winda.png"),
                        ],
                        [
                            'name' => 'Fadhal Rahman',
                            'role' => 'Specialist',
                            'image' => asset("images/landing/members/fadhal.png"),
                        ],
                    ];
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
                    @foreach ($team as $member)
                        <div class="transform transition-transform hover:-translate-y-2 duration-300">
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden h-full flex flex-col">
                                <div class="flex-grow flex flex-col items-center pb-4">
                                    <div class="w-full mx-auto mb-4">
                                        <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <h3 class="px-2 text-lg font-bold text-gray-800 text-center">{{ $member['name'] }}
                                    </h3>
                                    <p class="px-2 text-sm text-gray-600">{{ $member['role'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


                <div class="h-32 md:h-40"></div>
            </div>
        </section>
    </main>


    <footer id="contact" class="bg-green-50">
        <div class="container mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                <div class="lg:col-span-4">
                    <a href="#" class="flex items-center">
                        <img class="h-10 w-auto" src="{{ asset('images/logo.png') }}" alt="JakaAja Logo">
                    </a>
                    <p class="mt-4 text-gray-600">
                        Mempermudah proses pemesanan makanan di kantin Politeknik Negeri Batam untuk Civitas dan
                        pengelola kantin.
                    </p>
                </div>

                <div class="lg:col-span-4">
                    <h3 class="text-lg font-bold text-gray-900">Hubungi Kami</h3>
                    <ul class="mt-4 space-y-3 text-gray-600">
                        <li class="flex items-start">
                           <x-heroicon-o-map-pin class="flex-shrink-0 h-6 w-6 text-green-600 mr-3" />
                            <span>Jl. Ahmad Yani, Batam Kota, Kota Batam</span>
                        </li>
                        <li class="flex items-center">
                            <x-heroicon-o-phone class="flex-shrink-0 h-6 w-6 text-green-600 mr-3" />
                            <span>081374251290</span>
                        </li>
                        <li class="flex items-center">
                            <x-heroicon-o-envelope class="flex-shrink-0 h-6 w-6 text-green-600 mr-3" />
                            <span>afangku1105@gmail.com</span>
                        </li>
                        <li class="flex items-center">
                           <x-heroicon-o-clock class="flex-shrink-0 h-6 w-6 text-green-600 mr-3" />
                            <span>Senin - Jumat / 08:00 AM - 05:00 PM</span>
                        </li>
                    </ul>
                </div>

                <div class="lg:col-span-4">
                    <h3 class="text-lg font-bold text-gray-900">Galeri Instagram</h3>
                    <div class="mt-4 grid grid-cols-3 gap-2">
                        <a href="#"><img src="{{ asset('images/landing/instagram/1.png') }}"
                                class="rounded-lg hover:opacity-80 transition-opacity"></a>
                        <a href="#"><img src="{{ asset('images/landing/instagram/2.png') }}"
                                class="rounded-lg hover:opacity-80 transition-opacity"></a>
                        <a href="#"><img src="{{ asset('images/landing/instagram/3.png') }}"
                                class="rounded-lg hover:opacity-80 transition-opacity"></a>
                        <a href="#"><img src="{{ asset('images/landing/instagram/4.png') }}"
                                class="rounded-lg hover:opacity-80 transition-opacity"></a>
                        <a href="#"><img src="{{ asset('images/landing/instagram/5.png') }}"
                                class="rounded-lg hover:opacity-80 transition-opacity"></a>
                        <a href="#"><img src="{{ asset('images/landing/instagram/6.png') }}"
                                class="rounded-lg hover:opacity-80 transition-opacity"></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-green-800 py-4">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-white">
                © {{ date('Y') }} JakaAja. All Rights Reserved.
            </div>
        </div>
    </footer>

</body>

</html>
