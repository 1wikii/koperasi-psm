@extends('layouts.layout')

@section('title')
    <title>Produk</title>
@endsection

@section('main')

    <div class="min-h-screen w-full flex flex-col gap-y-6 p-6">
        <h1 class="w-full text-2xl font-bold text-center my-4">Produk</h1>

        <!-- Product -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-10">
            @php
                $products = [
                    ['id' => 1, 'title' => 'GIGABYTE B850 AORUS ELITE WIFI7 ICE - AMD Ryzen 39eaj RAM 4 GB', 'image' => 'produk/produk.png', 'price' => '10000'],
                    ['id' => 2, 'title' => 'GIGABYTE B850 AORUS ELITE WIFI7 ICE - AMD Ryzen 39eaj RAM 4 GB', 'image' => 'produk/produk.png', 'price' => '20000'],
                    ['id' => 3, 'title' => 'GIGABYTE B850 AORUS ELITE WIFI7 ICE - AMD Ryzen 39eaj RAM 4 GB', 'image' => 'produk/produk.png', 'price' => '30000'],
                    ['id' => 4, 'title' => 'GIGABYTE B850 AORUS ELITE WIFI7 ICE - AMD Ryzen 39eaj RAM 4 GB', 'image' => 'produk/produk.png', 'price' => '40000'],
                    ['id' => 5, 'title' => 'GIGABYTE B850 AORUS ELITE WIFI7 ICE - AMD Ryzen 39eaj RAM 4 GB', 'image' => 'produk/produk.png', 'price' => '50000'],
                    ['id' => 6, 'title' => 'GIGABYTE B850 AORUS ELITE WIFI7 ICE - AMD Ryzen 39eaj RAM 4 GB', 'image' => 'produk/produk.png', 'price' => '60000'],
                ];
             @endphp
            @foreach($products as $product)
                <x-produk.produk id="{{ $product['id'] }}" title="{{ $product['title'] }}" image="{{ $product['image'] }}"
                    price="{{ $product['price'] }}" />
            @endforeach
        </div>
    </div>

@endsection