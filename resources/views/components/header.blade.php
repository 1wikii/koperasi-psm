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

        <!-- Cart -->
        <div class="flex-shrink-0">
            <a href="{{ route('cart') }}"
                class="inline-flex items-center px-4 py-2 text-gray-700 hover:text-green-600 font-medium transition-colors duration-200 relative">

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" role="img"
                    aria-label="Shopping cart" class="inline-block">
                    <title>Shopping cart</title>
                    <g fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M3 3h2l1.6 9.6a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.6L21 6H6" />
                        <circle cx="10" cy="20" r="1.6" fill="currentColor" stroke="none" />
                        <circle cx="18" cy="20" r="1.6" fill="currentColor" stroke="none" />
                    </g>
                </svg>


                @if(auth()->check() && auth()->user()->carts()->count() > 0)
                    <span
                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full min-w-[20px] h-5 flex items-center justify-center px-1">
                        {{ auth()->user()->carts()->count() }}
                    </span>
                @endif
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
                        <img src="{{ asset(Auth::user()->profile_photo_path) }}" alt="Profile Picture"
                            class="w-8 h-8 rounded-full me-2">
                        {{ Auth::user()->name }}
                        <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">

                        <!-- Profile -->
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile
                        </a>

                        <!-- Pesanan -->
                        <a href="{{ route('home') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M8 11v6h8v-6M8 11H6a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2h-2">
                                </path>
                            </svg>
                            Pesanan
                        </a>

                        <!-- Alamat -->
                        <a href="{{ route('home') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                </path>
                            </svg>
                            Alamat
                        </a>

                        <!-- Separator -->
                        <div class="border-t border-gray-100 my-1"></div>

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