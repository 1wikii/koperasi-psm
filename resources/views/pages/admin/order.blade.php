@extends('layouts.admin-layout')

@section('title')
    <title>Manajemen Pesanan</title>
@endsection

@section('main')
    <div x-data="orderManagement()" class="container mx-auto px-4 pt-8 flex flex-col min-h-screen">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Kelola Pesanan</h1>

        </div>

        <!-- Search and Filter -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <!-- Search -->
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" x-model="searchQuery" @input="filterOrders" placeholder="Cari pesanan..."
                    class="shadow-lg w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-colors">
            </div>

            <!-- Status Filter -->
            <div class="relative">
                <select x-model="statusFilter" @change="filterOrders"
                    class="shadow-lg appearance-none bg-white border border-gray-300 rounded-lg px-4 py-3 pr-10 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-colors min-w-48">
                    <option value="">Semua</option>
                    <option value="waiting">Menunggu Konfirmasi</option>
                    <option value="sending">Dikirim</option>
                    <option value="completed">Selesai</option>
                    <option value="rejected">Dibatalkan</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            <!-- Sort Filter -->
            <div class="relative">
                <select x-model="sortBy" @change="filterOrders"
                    class="shadow-lg appearance-none bg-white border border-gray-300 rounded-lg px-4 py-3 pr-10 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-colors min-w-32">
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="highest">Total Tertinggi</option>
                    <option value="lowest">Total Terendah</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>


        <!-- Orders Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 max-h-screen overflow-auto">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-green-50">
                        <tr class="text-gray-900">
                            <th class="px-6 py-4 text-left text-xs font-medium  uppercase tracking-wider">ID
                                Pesanan</th>
                            <th class="px-6 py-4 text-left text-xs font-medium  uppercase tracking-wider">Nama
                                Pelanggan</th>
                            <th class="px-6 py-4 text-left text-xs font-medium  uppercase tracking-wider">
                                Tanggal Pesan</th>
                            <th class="px-6 py-4 text-left text-xs font-medium  uppercase tracking-wider">Total
                                Pembayaran</th>
                            <th class="px-6 py-4 text-left text-xs font-medium  uppercase tracking-wider">
                                Status Pesanan</th>
                            <th class="px-6 py-4 text-left text-xs font-medium  uppercase tracking-wider">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template x-for="order in paginatedOrders" :key="order.id">
                            <tr @click="openDetailModal(order)" class="hover:bg-gray-50 transition-colors cursor-pointer">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-green-600 font-medium" x-text="order.order_number"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-gray-900 font-medium" x-text="order.customer_name"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900" x-text="order.date"></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-gray-900 font-medium"
                                        x-text="formatCurrency(order.total_amount)"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full"
                                        :class="getStatusClass(order.status)" x-text="getStatusName(order.status)"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <!-- View Button -->
                                        <button type="button" @click="openDetailModal(order)"
                                            class="text-green-600 hover:text-green-400 transition-colors"
                                            title="Lihat Pesanan">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-8 h-8 text-green-600 hover:text-green-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12l2 2 4-4m1-6H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V8l-4-4z" />
                                            </svg>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <x-admin.empty-table data="filteredOrders" />

        </div>

        <!-- Detail modal -->
        <div x-show="showDetailModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @keydown.escape="closeDetailModal()" @click.self="closeDetailModal()"
            class="fixed inset-0 bg-black bg-opacity-50 z-70" style="display: none;">

            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="showDetailModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90" class="bg-white rounded-xl max-w-4xl w-full">

                    <!-- Modal Header -->
                    <div class="bg-green-600 text-white p-6 rounded-t-xl">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-2xl font-bold">Detail Pesanan</h2>
                                <p class="text-green-100 mt-1" x-text="'ID: ' + orderData?.order_number"></p>
                            </div>
                            <button @click="closeDetailModal()" class="text-white hover:text-gray-200 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Modal Content -->
                    <div class="p-6 max-h-[70vh] overflow-y-auto">
                        <!-- Status & Info Umum -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                            <!-- Status Waiting -->
                            <template x-if="orderData?.status == 'waiting'">
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L5.35 16.5c-.77.833.192 2.5 1.732 2.5z">
                                            </path>
                                        </svg>
                                        <span class="font-medium text-yellow-800"
                                            x-text="getStatusName(orderData?.status)"></span>
                                    </div>
                                    <p class="text-sm text-yellow-700 mt-1">Status pembayaran</p>
                                </div>
                            </template>

                            <!-- Status Sending -->
                            <template x-if="orderData?.status == 'sending'">
                                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                        <span class="font-medium text-blue-800"
                                            x-text="getStatusName(orderData?.status)"></span>
                                    </div>
                                    <p class="text-sm text-blue-700 mt-1">Pesanan sedang dikirim</p>
                                </div>
                            </template>

                            <!-- Status Completed -->
                            <template x-if="orderData?.status == 'completed'">
                                <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7">
                                            </path>
                                        </svg>
                                        <span class="font-medium text-green-800"
                                            x-text="getStatusName(orderData?.status)"></span>
                                    </div>
                                    <p class="text-sm text-green-700 mt-1">Pesanan telah selesai</p>
                                </div>
                            </template>

                            <!-- Status Rejected -->
                            <template x-if="orderData?.status == 'rejected'">
                                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12">
                                            </path>
                                        </svg>
                                        <span class="font-medium text-red-800"
                                            x-text="getStatusName(orderData?.status)"></span>
                                    </div>
                                    <p class="text-sm text-red-700 mt-1">Pesanan ditolak</p>
                                </div>
                            </template>

                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 6h6"></path>
                                    </svg>
                                    <span class="font-medium text-blue-800" x-text="orderData?.date"></span>
                                </div>
                                <p class="text-sm text-blue-700 mt-1">Tanggal pesanan</p>
                            </div>

                            <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                        </path>
                                    </svg>
                                    <span class="font-medium text-green-800"
                                        x-text="formatCurrency(orderData?.total_amount)"></span>
                                </div>
                                <p class="text-sm text-green-700 mt-1">Total pembayaran</p>
                            </div>
                        </div>

                        <!-- Customer Info & Shipping Address -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Customer Info -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Data Pelanggan
                                </h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Nama:</span>
                                        <span class="font-medium" x-text="orderData?.user.name"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Email:</span>
                                        <span class="font-medium" x-text="orderData?.user.email"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">No. HP:</span>
                                        <span class="font-medium" x-text="orderData?.user.phone"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Address -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                        </path>
                                    </svg>
                                    Alamat Pengiriman
                                </h3>
                                <div class="space-y-2">
                                    <p class="font-medium text-gray-900" x-text="orderData?.customer.name"></p>
                                    <p class="text-gray-700" x-html="orderData?.shipping_address.replace(/\n/g, '<br>')">
                                    </p>
                                    <p class="text-gray-600" x-text="'No. HP: ' + orderData?.customer_phone"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 7H6L5 9z"></path>
                                </svg>
                                Produk Pesanan
                            </h3>
                            <div class="bg-white border rounded-lg overflow-hidden">
                                <div class="divide-y divide-gray-200">
                                    <template x-for="product in orderData?.order_items" :key="product.id">
                                        <div class="p-4 flex items-center space-x-4">
                                            <img :src="baseUrl + product.products.images" :alt="product.products.name"
                                                class="w-20 h-20 object-cover rounded-lg">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900" x-text="product.products.name"></h4>
                                                <p class="text-sm text-gray-600" x-text="'Stok: ' + product.products.stock">
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-medium text-gray-900" x-text="product.quantity + 'x'"></p>
                                                <p class="text-sm text-gray-600" x-text="formatCurrency(product.price)"></p>
                                                <p class="font-semibold text-green-600"
                                                    x-text="formatCurrency(product.subtotal)"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Proof -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z">
                                    </path>
                                </svg>
                                Bukti Pembayaran
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <img :src="baseUrl + orderData?.payment.payment_proof" alt="Bukti Transfer"
                                            @click="openDetailImageModal()"
                                            class="w-48 h-64 object-cover rounded-lg border-2 border-gray-200 cursor-pointer hover:border-green-400 transition-colors">
                                    </div>
                                    <div class="flex-1">
                                        <div class="space-y-3">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Nama Bank:</span>
                                                <span class="font-medium" x-text="paymentAccount.bank_name"></span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">No. Rekening:</span>
                                                <span class="font-medium" x-text="paymentAccount.account_number"></span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Nama Penerima:</span>
                                                <span class="font-medium"
                                                    x-text="paymentAccount.account_holder_name"></span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Tanggal Transfer:</span>
                                                <span class="font-medium" x-text="orderData?.date"></span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Jumlah Transfer:</span>
                                                <span class="font-medium text-green-600"
                                                    x-text="formatCurrency(orderData?.total_amount)"></span>
                                            </div>
                                            <div class="pt-2">
                                                <button @click="showDetailImageModal = true"
                                                    class="text-green-600 hover:text-green-700 text-sm font-medium">
                                                    Lihat Gambar Penuh
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="bg-green-50 rounded-lg p-4 mb-6">
                            <h3 class="font-semibold text-gray-900 mb-3">Ringkasan Pesanan</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span>Subtotal Produk:</span>
                                    <span x-text="formatCurrency(orderData?.total_amount)"></span>
                                </div>
                                <hr class="border-green-200">
                                <div class="flex justify-between font-semibold text-lg text-green-800">
                                    <span>Total Pembayaran:</span>
                                    <span x-text="formatCurrency(orderData?.total_amount)"></span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 p-4 border-t">

                        <form :action="baseUrl + 'admin/order/reject/' + orderData?.id" method="POST">
                            @csrf
                            <button type="submit" :disabled="orderData?.status != 'waiting'"
                                :class="orderData?.status != 'waiting' ? 'opacity-50 cursor-not-allowed' : ''"
                                class="px-6 py-2 border border-red-300 text-red-700 rounded-lg hover:bg-red-50 hover:border-red-400 transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>Tolak Pembayaran</span>
                            </button>
                        </form>

                        <form :action="baseUrl + 'admin/order/approve/' + orderData?.id" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" :value="orderData?.id">

                            <template x-for="(item, index) in orderData?.order_items" :key="index">
                                <div>
                                    <input type="hidden" :name="`order_items[${index}][id]`" :value="item.id">
                                    <input type="hidden" :name="`order_items[${index}][quantity]`" :value="item.quantity">
                                    <input type="hidden" :name="`order_items[${index}][product_id]`"
                                        :value="item.product_id">
                                </div>
                            </template>


                            <button type="submit" :disabled="orderData?.status != 'waiting'"
                                :class="orderData?.status != 'waiting' ? 'opacity-50 cursor-not-allowed' : ''"
                                class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7">
                                    </path>
                                </svg>
                                <span>Terima Pembayaran</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Full Image Modal -->
        <div x-show="showDetailImageModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @keydown.escape="showDetailImageModal = false"
            @click.self="showDetailImageModal = false" class="fixed inset-0 bg-black bg-opacity-75 z-60"
            style="display: none;">

            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative">
                    <img :src="baseUrl + orderData?.payment.payment_proof" alt="Bukti Transfer"
                        class="max-w-full max-h-[90vh] rounded-lg">
                    <button @click="showDetailImageModal = false"
                        class="absolute top-4 right-4 bg-red-600 bg-opacity-70 text-white p-2 rounded-full hover:bg-opacity-30 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-auto">
            <!-- Pagination -->
            <x-admin.pagination data="filteredOrders" />
        </div>
    </div>

    <script>
        function orderManagement() {
            return {
                baseUrl: '{{ asset('') }}',
                // Sample data
                orders: @json($orders),
                paymentAccount: @json($paymentAccount),

                // Filter states
                searchQuery: '',
                statusFilter: 'waiting',
                sortBy: 'newest',

                // Pagination states
                currentPage: 1,
                itemsPerPage: 5,
                filteredOrders: [],

                // Detail modal states
                showDetailModal: false,
                showDetailImageModal: false,
                processing: false,
                orderData: null,

                init() {
                    const sorted = this.sortOrders(this.orders);

                    this.filteredOrders = sorted.filter(order => order.status == this.statusFilter);
                },

                get paginatedOrders() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;

                    return this.filteredOrders.slice(start, end);
                },

                filterOrders() {
                    let filtered = this.orders;

                    // Search filter
                    if (this.searchQuery) {
                        filtered = filtered.filter(order =>
                            order.customer_name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                            order.order_number.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                            order.date.toString().includes(this.searchQuery) ||
                            order.total_amount.toString().includes(this.searchQuery) ||
                            order.shipping_address.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                            order.user.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                            order.user.email.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                            order.user.phone.toLowerCase().includes(this.searchQuery.toLowerCase())
                        );
                    }

                    // Status filter
                    if (this.statusFilter) {
                        filtered = filtered.filter(order => order.status == this.statusFilter);
                    }

                    // Sort
                    this.filteredOrders = this.sortOrders(filtered);
                    this.currentPage = 1;
                },


                sortOrders(orders) {
                    const sorted = [...orders];

                    switch (this.sortBy) {
                        case 'newest':
                            return sorted.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                        case 'oldest':
                            return sorted.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                        case 'highest':
                            return sorted.sort((a, b) => b.total_amount - a.total_amount);
                        case 'lowest':
                            return sorted.sort((a, b) => a.total_amount - b.total_amount);
                        default:
                            return sorted;
                    }
                },

                get totalPages() {
                    return Math.ceil(this.filteredOrders.length / this.itemsPerPage);
                },

                getPageNumbers() {
                    const pages = [];
                    const maxVisible = 5;
                    let start = Math.max(1, this.currentPage - Math.floor(maxVisible / 2));
                    let end = Math.min(this.totalPages, start + maxVisible - 1);

                    if (end - start + 1 < maxVisible) {
                        start = Math.max(1, end - maxVisible + 1);
                    }

                    for (let i = start; i <= end; i++) {
                        pages.push(i);
                    }
                    return pages;
                },

                goToPage(page) {
                    if (page >= 1 && page <= this.totalPages) {
                        this.currentPage = page;
                    }
                },

                previousPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                    }
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                    }
                },

                formatCurrency(price) {
                    // Convert to number if it's a string
                    const numPrice = typeof price === 'string' ? parseFloat(price) : price;

                    // Format with Indonesian locale (dots as thousands separator)
                    return 'Rp ' + numPrice.toLocaleString('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    });
                },

                getStatusClass(status) {
                    switch (status) {
                        case 'waiting':
                            return 'bg-yellow-100 text-yellow-800';
                        case 'sending':
                            return 'bg-green-100 text-green-800';
                        case 'completed':
                            return 'bg-green-100 text-green-800';
                        case 'rejected':
                            return 'bg-red-100 text-red-800';
                        default:
                            return 'bg-gray-100 text-gray-800';
                    }
                },
                getStatusName(status) {
                    switch (status) {
                        case 'waiting':
                            return 'Menunggu Konfirmasi';
                        case 'sending':
                            return 'Dikirim';
                        case 'completed':
                            return 'Selesai';
                        case 'rejected':
                            return 'Dibatalkan';
                        default:
                            return status;
                    }
                },


                /**
                 * 
                 * Detail modal handlers
                 *
                 */

                openDetailModal(curOrder) {
                    this.orderData = curOrder;
                    this.showDetailModal = true;
                    document.body.classList.add('overflow-hidden');
                },

                closeDetailModal() {
                    this.showDetailModal = false;
                    this.showDetailImageModal = false;
                    document.body.classList.remove('overflow-hidden');
                },
                openDetailImageModal() {
                    this.showDetailImageModal = true;
                },
                approvePayment() {
                    if (!confirm('Apakah Anda yakin ingin menerima pembayaran ini?')) {
                        return;
                    }
                },

                rejectPayment() {
                    if (!confirm('Apakah Anda yakin ingin menolak pembayaran ini?')) {
                        return;
                    }
                },
            }
        }
    </script>

@endsection