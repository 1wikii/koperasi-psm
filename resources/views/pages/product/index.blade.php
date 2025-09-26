@extends('layouts.layout')

@section('title')
    <title>Produk</title>
@endsection

@section('main')

    <div class="min-h-screen w-full flex flex-col gap-y-6 p-6">
        <!-- Breadcrumb -->
        @if (request()->routeIs('products.index'))
            <x-breadcrumb />
        @else
            <x-breadcrumb :product="$products[0] ?? null" />
        @endif

        @if (isset($q) && count($products) == 0)
            <x-produk.empty-search />
        @else
            <!-- Product -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-10">

                @foreach($products as $product)
                    <x-produk.produk id="{{ $product['id'] }}" name="{{ $product['name'] }}" image="{{ $product['images'] }}"
                        price="{{ $product['price'] }}" slug="{{ $product->slug }}" />
                @endforeach
            </div>
        @endif


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

@endsection