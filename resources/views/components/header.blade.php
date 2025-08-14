<!-- Header -->
<header class="">
    <div class="flex items-center justify-between h-16">
        <!-- Logo -->
        <div class="flex-shrink-0 flex items-center">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('logo.svg') }}" alt="Koperasi PSM" class="w-10 h-10">
            </a>
        </div>

        <!-- Search Bar -->
        <div class="flex-1 max-w-2xl mx-8">
            <form action="{{ route('home') }}" method="GET" class="relative">
                <div class="relative">
                    <input type="text" name="q" placeholder="Cari Produk" value="{{ request('q') }}"
                        class="w-full pl-4 pr-12 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition-all duration-200">
                    <button type="submit"
                        class="absolute right-1 top-1/2 transform -translate-y-1/2 bg-green-600 hover:bg-green-700 text-white p-2 rounded-full transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Login Button -->
        <div class="flex-shrink-0">
            @guest
                <a href="{{ route('login') }}"
                    class="inline-flex items-center px-6 py-2 border border-green-600 text-green-600 hover:bg-green-600 hover:text-white rounded-full font-medium transition-all duration-200">
                    Login
                </a>
            @else
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="inline-flex items-center px-4 py-2 text-gray-700 hover:text-green-600 font-medium transition-colors duration-200">
                        {{ Auth::user()->name }}
                        <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('home') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                        <a href="{{ route('home') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pesanan</a>
                        <form method="POST" action="{{ route('home') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</header>

<!-- Navigation Menu -->
<nav class="bg-green-600 text-white sticky top-0 z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center space-x-8 h-12">
            <a href="{{ route('home') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('home') ? 'bg-green-700' : '' }}">
                Beranda
            </a>
            <a href="{{ route('product') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('product') ? 'bg-green-700' : '' }}">
                Produk
            </a>
            <a href="{{ route('about-us') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('about-us') ? 'bg-green-700' : '' }}">
                Tentang Kami
            </a>
            <a href="{{ route('cart') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('cart') ? 'bg-green-700' : '' }}">
                Keranjang
                @if(auth()->check() && auth()->user()->cartItems()->count() > 0)
                    <span class="ml-1 bg-red-500 text-white text-xs rounded-full px-2 py-0.5">
                        {{ auth()->user()->cartItems()->count() }}
                    </span>
                @endif
            </a>

            <!-- Categories Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200">
                    Kategori
                    <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false"
                    class="absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-50">
                    @php
                        $categories = [
                            ['id' => 1, 'name' => 'Makanan', 'slug' => 'makanan'],
                            ['id' => 2, 'name' => 'Minuman', 'slug' => 'minuman'],
                            ['id' => 3, 'name' => 'Kesehatan', 'slug' => 'kesehatan'],
                            ['id' => 4, 'name' => 'Elektronik', 'slug' => 'elektronik'],
                            ['id' => 5, 'name' => 'Pakaian', 'slug' => 'pakaian'],
                            ['id' => 6, 'name' => 'Rumah Tangga', 'slug' => 'rumah-tangga'],
                        ];

                    @endphp
                    @foreach($categories as $category)
                        <a href="{{ route('home', $category['slug']) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ $category['name'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</nav>