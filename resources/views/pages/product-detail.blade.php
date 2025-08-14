@extends('layouts.layout')

@section('title')
    <title>Product Detail</title>
@endsection

@section('main')
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

            <!-- Product Image Section -->
            <div class="space-y-4">
                <!-- Main Product Image -->
                <div class="aspect-square bg-black rounded-2xl overflow-hidden">
                    @if(isset($product) && $product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover">
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
                        {{ $product->category->name ?? 'Lorem Ipsum' }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">Stok Tersedia:</span>
                        <span class="font-semibold text-gray-900">{{ $product->stock ?? '32' }}</span>
                    </p>
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="space-y-6">
                <!-- Product Title -->
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 leading-tight mb-4">
                        {{ $product->name ?? 'LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING' }}
                    </h1>

                    <!-- Price -->
                    <div class="mb-6">
                        <span class="text-3xl lg:text-4xl font-bold text-gray-900">
                            Rp{{ number_format($product->price ?? 117000, 0, ',', '.') }}
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
                            @else
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet,
                                    consectetur adipiscing elit Lorem ipsum Lorem ipsum dolor sit amet, consectetur adipiscing
                                    elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit Lorem ipsumLorem ipsum dolor
                                    sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing
                                    elit Lorem ipsumLorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor
                                    sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing
                                    elit Lorem ipsumLorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor
                                    sit amet, consectetur adipiscing elit Lorem ipsumLorem ipsum dolor sit amet, consectetur
                                    adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit Lorem ipsumLorem
                                    ipsum dolor sit amet, consectetur...
                                </p>
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
                        <span class="text-gray-900">{{ $product->category->name ?? 'Lorem Ipsum' }}</span>
                    </p>
                    <p class="text-gray-600">
                        <span class="font-medium">Stok Tersedia:</span>
                        <span class="font-semibold text-gray-900">{{ $product->stock ?? '32' }}</span>
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <!-- Buy Now Button -->
                    <button type="button"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
                        onclick="buyNow()">
                        Beli Sekarang
                    </button>

                    <!-- Add to Cart Button -->
                    <button type="button"
                        class="flex-1 bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                        onclick="addToCart({{ $product->id ?? 1 }})">
                        Tambah Ke Keranjang
                    </button>
                </div>

                <!-- Additional Product Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <!-- Share Button -->
                    <!-- <button type="button"
                        class="flex items-center text-gray-600 hover:text-gray-800 transition-colors duration-200"
                        onclick="shareProduct()">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z">
                            </path>
                        </svg>
                        Bagikan
                    </button> -->

                    <!-- Favorite Button -->
                    <!-- <button type="button"
                        class="flex items-center text-gray-600 hover:text-red-500 transition-colors duration-200"
                        onclick="toggleFavorite({{ $product->id ?? 1 }})">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                        Favorit
                    </button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Add to Cart Success Modal -->
    <div id="cartModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Berhasil Ditambahkan!</h3>
                <p class="text-sm text-gray-500 mb-4">Produk telah ditambahkan ke keranjang Anda.</p>
                <div class="flex justify-center space-x-3">
                    <button type="button"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-200"
                        onclick="closeCartModal()">
                        Lanjut Belanja
                    </button>
                    <a href="{{ route('cart') }}"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200">
                        Lihat Keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        let isDescriptionExpanded = false;

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

        function addToCart(productId) {
            // Show loading state
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Menambahkan...';
            button.disabled = true;

            // Simulate API call
            setTimeout(() => {
                // Reset button
                button.textContent = originalText;
                button.disabled = false;

                // Show success modal
                document.getElementById('cartModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                // In real application, make AJAX call to add to cart
                // fetch('/cart/add', { ... })
            }, 1000);
        }

        function buyNow() {
            // Redirect to checkout or show buy now modal
            window.location.href = '{{ route("checkout") }}';
        }

        function shareProduct() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $product->name ?? "Lorem Ipsum Product" }}',
                    text: 'Lihat produk ini!',
                    url: window.location.href
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href);
                alert('Link produk telah disalin ke clipboard!');
            }
        }

        function toggleFavorite(productId) {
            const button = event.target.closest('button');
            const svg = button.querySelector('svg');

            // Toggle visual state
            if (svg.getAttribute('fill') === 'currentColor') {
                svg.setAttribute('fill', 'none');
                button.classList.remove('text-red-500');
                button.classList.add('text-gray-600');
            } else {
                svg.setAttribute('fill', 'currentColor');
                button.classList.remove('text-gray-600');
                button.classList.add('text-red-500');
            }

            // In real application, make AJAX call to toggle favorite
            // fetch('/favorites/toggle', { ... })
        }

        function closeCartModal() {
            document.getElementById('cartModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

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

        // Close modal when clicking outside
        document.getElementById('cartModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeCartModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeCartModal();
            }
        });
    </script>

@endsection