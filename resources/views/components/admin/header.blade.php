<!-- Header -->
<header class="">
    <div class="flex items-center justify-between h-16">
        <!-- Logo -->
        <div class="flex-shrink-0 flex items-center">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('logo.svg') }}" alt="Koperasi PSM" class="w-10 h-10">
            </a>
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
            <a href="{{ route('admin.dashboard') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-green-700' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('product') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('product') ? 'bg-green-700' : '' }}">
                Kategori
            </a>
            <a href="{{ route('about-us') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('about-us') ? 'bg-green-700' : '' }}">
                Produk
            </a>
            <a href="{{ route('cart') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('cart') ? 'bg-green-700' : '' }}">
                Pesanan
            </a>
            <a href="{{ route('cart') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('cart') ? 'bg-green-700' : '' }}">
                Pembayaran
            </a>

            <a href="{{ route('cart') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('cart') ? 'bg-green-700' : '' }}">
                Pengiriman
            </a>

            <a href="{{ route('cart') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('cart') ? 'bg-green-700' : '' }}">
                Pengembalian
            </a>
        </div>
    </div>
</nav>