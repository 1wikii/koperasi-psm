@extends('layouts.layout')

@section('title')
    <title>Koperasi PSM</title>
@endsection

@section('main')

    <div class="w-full flex flex-col gap-y-10">

        <!-- Hero -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center py-16">
            <div class="space-y-6">
                <h1 class="text-4xl font-bold text-gray-800">Selamat Datang di Koperasi PSM</h1>
                <p class="text-gray-600">Koperasi PSM menyediakan berbagai produk berkualitas untuk memenuhi kebutuhan Anda.
                </p>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-full hover:bg-green-700 transition-colors duration-200">
                    Jelajahi Produk
                </a>
            </div>
            <div class="flex justify-center">
                <img src="{{ asset('logo.svg') }}" alt="Hero Image" class="w-full max-w-md">
            </div>
        </div>

        <!-- Kategori -->
        <div class="flex flex-col">
            <p class="font-bold mb-4">Kategori</p>
            <div class="flex gap-3">
                @foreach ($categories as $item)
                    <x-kategori name="{{ $item['name'] }}" image="{{ $item['image'] }}" slug="{{ $item['slug'] }}" />
                @endforeach
            </div>
        </div>

        <div class="flex flex-col">
            <p class="font-bold mb-4">Produk</p>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach ($products as $item)
                    <x-produk.produk slug="{{ $item['slug'] }}" name="{{ $item['name'] }}" image="{{ $item['images'] }}"
                        price="{{ $item['price'] }}" slug="{{ $item->slug }}" />
                @endforeach
            </div>
        </div>


        <!-- Pagination -->
        <div class="my-6 flex justify-center">
            <nav class="flex items-center space-x-2" aria-label="Pagination">
                {{-- Previous Page --}}
                @if ($products->onFirstPage())
                    <span class="px-3 py-1 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">Prev</span>
                @else
                    <a href="{{ $products->previousPageUrl() }}"
                        class="px-3 py-1 rounded-lg bg-white border text-green-600 hover:bg-green-50">
                        Prev
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if ($page == $products->currentPage())
                        <span class="px-3 py-1 rounded-lg bg-green-600 text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 rounded-lg bg-white border text-green-600 hover:bg-green-50">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next Page --}}
                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}"
                        class="px-3 py-1 rounded-lg bg-white border text-green-600 hover:bg-green-50">
                        Next
                    </a>
                @else
                    <span class="px-3 py-1 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">Next</span>
                @endif
            </nav>
        </div>

    </div>

    <!-- Simpan token untuk digunakan di frontend -->
    <script>
        window.apiToken = "{{ session('api_token') }}";
    </script>

@endsection