@extends('layouts.layout')

@section('title')
    <title>Product Detail</title>
@endsection

@section('main')

    <div class="container mx-auto px-4 py-8">

        <!-- Breadcrumb -->
        <x-breadcrumb :product="$product ?? null" />


        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

            <!-- Product Image Section -->
            <div class="space-y-4">
                <!-- Main Product Image -->
                <div class="aspect-square bg-black rounded-2xl overflow-hidden">
                    @if(isset($product) && $product->images)
                        <img src="{{ asset($product->images) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Product Info (Mobile/Tablet) -->
                <div class="lg:hidden space-y-2">
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">Kategori:</span>
                        {{ $product->category->name }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">Stok Tersedia:</span>
                        <span class="font-semibold text-gray-900">{{ $product->stock }}</span>
                    </p>
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="space-y-6">
                <!-- Product Title -->
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 leading-tight mb-4">
                        {{ $product->name }}
                    </h1>

                    <!-- Price -->
                    <div class="mb-6">
                        <span class="text-3xl lg:text-4xl font-bold text-gray-900">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- Description Section -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi</h3>
                    <div class="w-16 h-0.5 bg-gray-300 mb-4"></div>

                    <div class="text-gray-700 leading-relaxed space-y-4">
                        <div id="description-content">
                            @if(isset($product) && $product->description)
                                {!! nl2br(e($product->description)) !!}
                            @endif
                        </div>

                        <!-- Show More/Less Button -->
                        <button type="button" id="toggle-description"
                            class="text-green-600 hover:text-green-700 font-medium transition-colors duration-200"
                            onclick="toggleDescription()">
                            Lihat Selengkapnya
                        </button>
                    </div>
                </div>

                <!-- Product Info (Desktop) -->
                <div class="hidden lg:block space-y-3 pt-4 border-t border-gray-200">
                    <p class="text-gray-600">
                        <span class="font-medium">Kategori:</span>
                        <span class="text-gray-900">{{ $product->category->name }}</span>
                    </p>
                    <p class="text-gray-600">
                        <span class="font-medium">Stok Tersedia:</span>
                        <span class="font-semibold text-gray-900">{{ $product->stock }}</span>
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <!-- Buy Now Button -->
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit"
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                            Beli Sekarang
                        </button>
                    </form>

                    <!-- Add to Cart Button -->
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="price" value="{{ $product->price }}">
                        <button type="submit"
                            class="flex-1 bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            Tambah Ke Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add to Cart Success Modal -->
    @if (session('success'))
        <div x-data="{ open: true }">
            <template x-if="open">
                <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50">
                    <div class="absolute inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full"></div>
                    <div @click.outside="open = false"
                        class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
                        <div class="text-center">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Berhasil Ditambahkan!</h3>
                            <p class="text-sm text-gray-500 mb-4">Produk telah ditambahkan ke keranjang Anda.</p>
                            <div class="flex justify-center space-x-3">
                                <button type="button"
                                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-200"
                                    @click="open = false">
                                    Lanjut Belanja
                                </button>
                                <a href="{{ route('cart.index') }}"
                                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200">
                                    Lihat Keranjang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

    @endif
    <script>
        let isDescriptionExpanded = false;

        // Initialize description truncation
        document.addEventListener('DOMContentLoaded', function () {
            const content = document.getElementById('description-content');
            if (content.scrollHeight > 96) { // 6rem = 96px
                content.style.maxHeight = '6rem';
                content.style.overflow = 'hidden';
                document.getElementById('toggle-description').style.display = 'block';
            } else {
                document.getElementById('toggle-description').style.display = 'none';
            }
        });

        function toggleDescription() {
            const content = document.getElementById('description-content');
            const button = document.getElementById('toggle-description');

            if (isDescriptionExpanded) {
                content.style.maxHeight = '6rem';
                content.style.overflow = 'hidden';
                button.textContent = 'Lihat Selengkapnya';
                isDescriptionExpanded = false;
            } else {
                content.style.maxHeight = 'none';
                content.style.overflow = 'visible';
                button.textContent = 'Lihat Lebih Sedikit';
                isDescriptionExpanded = true;
            }
        }
    </script>

@endsection