<!-- Header -->
<header>
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
                        <div
                            class="me-1 w-8 h-8 rounded-full border-4 border-gray-200 bg-gray-100 overflow-hidden relative">
                            <img src="{{ asset(Auth::user()->profile_photo_path) }}" alt="Profile Picture"
                                class="w-full h-full object-cover">
                        </div>
                        {{ Auth::user()->name }}
                        <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-gray-100 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</header>

<!-- Navigation Menu -->
<nav class="flex justify-center items-center p-1 bg-green-600 text-white sticky top-0">
    <div class="flex justify-center items-center px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center items-center gap-x-4 gap-y-2">
            <a href="{{ route('admin.dashboard') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-green-700' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.category') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('admin.category') ? 'bg-green-700' : '' }}">
                Kategori
            </a>
            <a href="{{ route('admin.products') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('admin.products') ? 'bg-green-700' : '' }}">
                Produk
            </a>
            <a href="{{ route('admin.orders') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('admin.orders') ? 'bg-green-700' : '' }}">
                Pesanan
            </a>

            @if(Auth::user()->role === 'super_admin')
                <a href="{{ route('superadmin.payment-accounts.index') }}"
                    class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('superadmin.payment-accounts.index') ? 'bg-green-700' : '' }}">
                    Akun Bank
                </a>
            @endif

            <!--
            <a href="{{ route('admin.shippings') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('admin.shippings') ? 'bg-green-700' : '' }}">
                Pengiriman
            </a>

            <a href="{{ route('admin.returns') }}"
                class="hover:bg-green-700 px-3 py-2 rounded transition-colors duration-200 {{ request()->routeIs('admin.returns') ? 'bg-green-700' : '' }}">
                Pengembalian
            </a> -->
        </div>
    </div>
</nav>