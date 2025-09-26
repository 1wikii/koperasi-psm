@extends('layouts.layout')

@section('title')
    <title>Profile</title>
@endsection

@section('main')

    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-[auto_1fr] items-start gap-8 px-6 py-14 md:grid">
        <!-- Left Sidebar -->
        <x-profile.sidebar />

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200/60" x-data="orderManager()">
            <div class="container mx-auto px-4 py-8">
                {{-- Header --}}
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Pesananku</h1>
                </div>

                <!-- Search and Filter Section -->
                <div class="mb-6 space-y-4">
                    <!-- Search Bar -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" x-model="searchQuery" @input="filterOrders()"
                            placeholder="Cari pesanan berdasarkan nomor order atau nama produk..."
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                    </div>

                    <!-- Status Filter Tabs -->
                    <div class="flex flex-wrap gap-2">
                        <button @click="selectedStatus = 'all'; filterOrders()"
                            :class="selectedStatus === 'all' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                            class="px-4 py-2 rounded-lg font-medium transition-colors">
                            Semua (<span x-text="orders.length"></span>)
                        </button>
                        <button @click="selectedStatus = 'waiting'; filterOrders()"
                            :class="selectedStatus === 'waiting' ? 'bg-yellow-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                            class="px-4 py-2 rounded-lg font-medium transition-colors">
                            Menunggu (<span x-text="getOrdersByStatus('waiting').length"></span>)
                        </button>
                        <button @click="selectedStatus = 'sending'; filterOrders()"
                            :class="selectedStatus === 'sending' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                            class="px-4 py-2 rounded-lg font-medium transition-colors">
                            Dikirim (<span x-text="getOrdersByStatus('sending').length"></span>)
                        </button>
                        <button @click="selectedStatus = 'completed'; filterOrders()"
                            :class="selectedStatus === 'completed' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                            class="px-4 py-2 rounded-lg font-medium transition-colors">
                            Selesai (<span x-text="getOrdersByStatus('completed').length"></span>)
                        </button>
                        <button @click="selectedStatus = 'rejected'; filterOrders()"
                            :class="selectedStatus === 'rejected' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                            class="px-4 py-2 rounded-lg font-medium transition-colors">
                            Ditolak (<span x-text="getOrdersByStatus('rejected').length"></span>)
                        </button>
                    </div>
                </div>

                <!-- Orders List -->
                <div class="space-y-4 max-h-[50vh] overflow-y-auto">
                    <template x-for="order in getFilteredOrders" :key="order.id">
                        <div class="border border-gray-200 rounded-lg hover:shadow-md transition-shadow duration-200">
                            <!-- Order Header -->
                            <div class="p-4 border-b border-gray-100">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                        <div class="flex items-center gap-3">
                                            <h3 class="font-semibold text-gray-900" x-text="order.order_number">
                                            </h3>
                                            <span
                                                :class="{
                                                                                                                                                                                                                                                                                        'bg-yellow-100 text-yellow-800 border-yellow-200': order.status === 'waiting',
                                                                                                                                                                                                                                                                                        'bg-blue-100 text-blue-800 border-blue-200': order.status === 'sending', 
                                                                                                                                                                                                                                                                                        'bg-green-100 text-green-800 border-green-200': order.status === 'completed',
                                                                                                                                                                                                                                                                                        'bg-red-100 text-red-800 border-red-200': order.status === 'rejected'
                                                                                                                                                                                                                                                                                    }"
                                                class="px-2 py-1 text-xs font-medium rounded-full border"
                                                x-text="getStatusText(order.status)"></span>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <span x-text="order.date"></span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button @click="toggleOrderDetails(order.id)"
                                            class="text-green-600 hover:text-green-700 font-medium text-sm flex items-center gap-1">
                                            <span>Detail</span>
                                            <svg :class="order.showDetails ? 'rotate-180' : ''"
                                                class="w-4 h-4 transition-transform" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div class="p-4">

                                <template x-for="item in order.order_items" :key="item.id">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <img :src="baseUrl + item.products.images" :alt="item.products.name"
                                                class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                                            <div>
                                                <p class="font-medium text-gray-900" x-text="item.products.name"></p>
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    <span x-text="item.quantity"></span> item
                                                    <template x-if="item.length > 1">
                                                        <span x-text="`+${item.length - 1} produk lainnya`"></span>
                                                    </template>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-gray-900" x-text="formatCurrency(item.price)"></p>
                                        </div>
                                    </div>
                                </template>
                                <p class="w-full text-right font-bold" x-text="formatCurrency(order.total_amount)"></p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-wrap gap-2 pb-4 pt-2 px-4">
                                <template x-if="order.status === 'sending'">
                                    <button @click="confirmOrder(order.id)"
                                        class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                                        Konfirmasi Pesanan Diterima
                                    </button>
                                </template>
                            </div>
                        </div>

                        <!-- Order Details (Collapsible) -->
                        <div x-show="order.showDetails" x-transition class="border-t border-gray-100">
                            <div class="p-4 space-y-4">
                                <!-- Shipping Address -->
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-2">Alamat Pengiriman</h4>
                                    <div class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">
                                        <p class="font-medium" x-text="order.shipping_address.name"></p>
                                        <p x-text="order.shipping_address.phone"></p>
                                        <p x-text="order.shipping_address.address"></p>
                                    </div>
                                </div>

                                <!-- Order Items -->
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-2">Detail Pesanan</h4>
                                    <div class="space-y-3">
                                        <template x-for="item in order.items" :key="item.id">
                                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                                <img :src="item.product_image" :alt="item.product_name"
                                                    class="w-16 h-16 rounded-lg object-cover border border-gray-200">
                                                <div class="flex-1">
                                                    <p class="font-medium text-gray-900" x-text="item.product_name"></p>
                                                    <p class="text-sm text-gray-500"
                                                        x-text="`${item.quantity} x Rp ${item.price.toLocaleString('id-ID')}`">
                                                    </p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="font-medium text-gray-900"
                                                        x-text="`Rp ${(item.quantity * item.price).toLocaleString('id-ID')}`">
                                                    </p>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Order Summary -->
                                <div class="border-t pt-4">
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span>Subtotal</span>
                                            <span x-text="`Rp ${order.subtotal.toLocaleString('id-ID')}`"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Ongkos Kirim</span>
                                            <span x-text="`Rp ${order.shipping_cost.toLocaleString('id-ID')}`"></span>
                                        </div>
                                        <div class="flex justify-between font-semibold text-base border-t pt-2">
                                            <span>Total</span>
                                            <span x-text="`Rp ${order.total_amount.toLocaleString('id-ID')}`"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Timeline -->
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-3">Status Pesanan</h4>
                                    <div class="space-y-3">
                                        <template x-for="(timeline, index) in order.timeline" :key="index">
                                            <div class="flex items-start gap-3">
                                                <div :class="timeline.completed ? 'bg-green-600' : 'bg-gray-300'"
                                                    class="w-3 h-3 rounded-full mt-1 flex-shrink-0"></div>
                                                <div class="flex-1">
                                                    <p :class="timeline.completed ? 'text-gray-900 font-medium' : 'text-gray-500'"
                                                        class="text-sm" x-text="timeline.title"></p>
                                                    <p :class="timeline.completed ? 'text-gray-600' : 'text-gray-400'"
                                                        class="text-xs" x-text="timeline.date"></p>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </template>

                <!-- Empty State -->
                <div x-show="filteredOrders?.length === 0" class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M8 11v6h8v-6M8 11H6a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2h-2">
                        </path>
                    </svg>
                    <p class="text-gray-500 text-lg font-medium mb-2">Tidak ada pesanan ditemukan</p>
                    <p class="text-gray-400">Coba ubah filter atau kata kunci pencarian</p>
                </div>
            </div>

            <!-- Confirmation Modal -->
            <div x-show="showConfirmModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showConfirmModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
                        @click="showConfirmModal = false"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                    <div x-show="showConfirmModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Konfirmasi Pesanan Diterima
                        </h3>
                        <p class="text-sm text-gray-600 text-center mb-6">Apakah Anda yakin pesanan sudah diterima
                            dengan baik?
                            Tindakan ini tidak dapat dibatalkan.</p>

                        <div class="flex gap-3">
                            <button @click="showConfirmModal = false"
                                class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                Batal
                            </button>
                            <button @click="processConfirmation()"
                                class="flex-1 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors">
                                Ya, Konfirmasi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirmation Form -->
            <form id="form-confirm" action="" method="POST">
                @csrf
            </form>
        </div>
    </div>
    </div>


    <script>
        function orderManager() {
            return {
                baseUrl: '{{ asset('') }}',

                orders: @json($orders),

                searchQuery: '',
                selectedStatus: 'all',
                showConfirmModal: false,
                selectedOrderId: null,
                filteredOrders: [],
                formConfirmActtion: '',

                init() {
                    this.filterOrders();
                },
                filterOrders() {
                    let filtered = this.orders;

                    // Filter by status
                    if (this.selectedStatus !== 'all') {
                        filtered = filtered.filter(order => order.status === this.selectedStatus);
                    }

                    // Filter by search query
                    if (this.searchQuery) {
                        const query = this.searchQuery.toLowerCase();
                        filtered = filtered.filter(order =>
                            order.order_number.toLowerCase().includes(query) ||
                            order.total_amount.toString().includes(query) ||
                            order.order_items.some(item => item.products.name.toLowerCase().includes(query)) ||
                            order.order_items.some(item => item.products.description.toLowerCase().includes(query))
                        );
                    }
                    this.filteredOrders = filtered;
                },

                get getFilteredOrders() {
                    return this.filteredOrders;
                },

                getOrdersByStatus(status) {
                    return this.orders.filter(order => order.status === status);
                },

                getStatusText(status) {
                    const statusMap = {
                        'waiting': 'Menunggu',
                        'sending': 'Dikirim',
                        'completed': 'Selesai',
                        'rejected': 'Ditolak'
                    };
                    return statusMap[status] || status;
                },

                toggleOrderDetails(orderId) {
                    const order = this.orders.find(o => o.id === orderId);
                    if (order) {
                        order.showDetails = !order.showDetails;
                    }
                },

                confirmOrder(orderId) {
                    this.selectedOrderId = orderId;
                    this.showConfirmModal = true;
                },

                processConfirmation() {
                    if (this.selectedOrderId) {
                        const url = this.formConfirmActtion = this.baseUrl + 'user/profile/orders/' + this.selectedOrderId;
                        document.getElementById('form-confirm').setAttribute('action', url);
                        document.getElementById('form-confirm').submit();
                    }
                    this.showConfirmModal = false;
                    this.selectedOrderId = null;
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
            }
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

@endsection