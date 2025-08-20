@extends('layouts.admin-layout')

@section('title')
    <title>Dashboard</title>
@endsection

@section('main')

    @php
        $stats = [
            'total_orders' => 2354,
            'total_payments' => 1847,
            'total_returns' => 127,
            'total_delivered' => 1720,
        ];
    @endphp

    <div class="h-full p-6">
        <!-- Header -->
        <h1 class="text-3xl font-bold text-gray-900 mb-12">Dashboard</h1>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">

            <!-- Card 1: Jumlah Pesanan -->
            <div class="flex justify-center items-center">
                <div
                    class="w-1/2 bg-white rounded-xl shadow-lg border border-blue-500 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-gray-600">Jumlah Pesanan</h3>
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center items-center">
                        <span
                            class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($stats['total_orders']) }}</span>
                        <div class="flex items-center">
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <span class="w-2 h-2 bg-blue-600 rounded-full mr-1"></span>
                                Total
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Jumlah Pembayaran -->
            <div class="flex justify-center items-center">
                <div
                    class="w-1/2 bg-white rounded-xl shadow-lg border border-green-500 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-gray-600">Jumlah Pembayaran</h3>
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center items-center">
                        <span
                            class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($stats['total_payments']) }}</span>
                        <div class="flex items-center">
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-600 rounded-full mr-1"></span>
                                Total
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Jumlah Retur -->
            <div class="flex justify-center items-center">
                <div
                    class="w-1/2 bg-white rounded-xl shadow-lg border border-red-500 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-gray-600">Jumlah Retur</h3>
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center items-center">
                        <span
                            class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($stats['total_returns']) }}</span>
                        <div class="flex items-center">
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <span class="w-2 h-2 bg-red-600 rounded-full mr-1"></span>
                                Total
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Jumlah Berhasil Dikirim -->
            <div class="flex justify-center items-center">
                <div
                    class="w-1/2 bg-white rounded-xl shadow-lg border border-yellow-500 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-gray-600">Jumlah Berhasil Dikirim</h3>
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.63.63-.184 1.707.707 1.707H19M17 17v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center items-center">
                        <span
                            class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($stats['total_delivered']) }}</span>
                        <div class="flex items-center">
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <span class="w-2 h-2 bg-yellow-600 rounded-full mr-1"></span>
                                Total
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection