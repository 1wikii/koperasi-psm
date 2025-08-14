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
                <a href="{{ route('home') }}"
                    class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-full hover:bg-green-700 transition-colors duration-200">
                    Jelajahi Produk
                </a>
            </div>
            <div class="flex justify-center">
                <img src="{{ asset('logo.svg') }}" alt="Hero Image" class="w-full max-w-md">
            </div>
        </div>

        <!-- Kategori -->
        @php
            $kategori = [
                ['id' => 1, 'title' => 'Makanan'],
                ['id' => 2, 'title' => 'Minuman'],
                ['id' => 3, 'title' => 'Kesehatan'],
                ['id' => 4, 'title' => 'Elektronik'],
                ['id' => 5, 'title' => 'Pakaian'],
                ['id' => 6, 'title' => 'Rumah Tangga'],
            ];
         @endphp

        <div class="flex flex-col">
            <p class="font-bold mb-4">Kategori</p>
            <div class="flex gap-3">`
                @foreach ($kategori as $item)
                    <x-kategori id="{{ $item['id'] }}" title="{{ $item['title'] }}" />
                @endforeach
            </div>
        </div>

        <!-- Produk -->
        @php
            $produk = [
                ['id' => 1, 'title' => 'GIGABYTE B850 AORUS ELITE WIFI7 ICE - AMD Ryzen 39eaj RAM 4 GB', 'image' => 'produk/produk.png', 'price' => '10000'],
                ['id' => 2, 'title' => 'GIGABYTE B850 AORUS ELITE WIFI7 ICE - AMD Ryzen 39eaj RAM 4 GB', 'image' => 'produk/produk.png', 'price' => '20000'],
                ['id' => 3, 'title' => 'GIGABYTE B850 AORUS ELITE WIFI7 ICE - AMD Ryzen 39eaj RAM 4 GB', 'image' => 'produk/produk.png', 'price' => '30000'],
                ['id' => 4, 'title' => 'GIGABYTE B850 AORUS ELITE WIFI7 ICE - AMD Ryzen 39eaj RAM 4 GB', 'image' => 'produk/produk.png', 'price' => '40000'],
                ['id' => 5, 'title' => 'GIGABYTE B850 AORUS ELITE WIFI7 ICE - AMD Ryzen 39eaj RAM 4 GB', 'image' => 'produk/produk.png', 'price' => '50000'],
                ['id' => 6, 'title' => 'GIGABYTE B850 AORUS ELITE WIFI7 ICE - AMD Ryzen 39eaj RAM 4 GB', 'image' => 'produk/produk.png', 'price' => '60000'],
            ];
         @endphp
        <div class="flex flex-col">
            <p class="font-bold mb-4">Produk</p>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach ($produk as $item)
                    <x-produk.produk id="{{ $item['id'] }}" title="{{ $item['title'] }}" image="{{ $item['image'] }}"
                        price="{{ $item['price'] }}" />
                @endforeach
            </div>
        </div>

    </div>

@endsection