@extends('layouts.admin-layout')

@section('title')
    <title>Manajemen Pesanan</title>
@endsection

@section('main')
    <div x-data="orderManagement()" class="container mx-auto px-4 py-6">
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
                    <option value="">Semua Status</option>
                    <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Dikirim">Dikirim</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Dibatalkan">Dibatalkan</option>
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

            <!-- Add Button -->
            <button
                class="bg-green-600 hover:bg-green-700 shadow-lg text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                <span class="text-lg">+</span>
                Tambah Pesanan
            </button>
        </div>


        <!-- Orders Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
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
                            <th class="px-6 py-4 text-left text-xs font-medium  uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template x-for="order in paginatedOrders" :key="order.id">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-green-600 font-medium" x-text="order.id"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-gray-900 font-medium" x-text="order.customer"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900" x-text="order.date"></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-gray-900 font-medium" x-text="formatCurrency(order.total)"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full"
                                        :class="getStatusClass(order.status)" x-text="order.status"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <!-- View Button -->
                                        <button class="text-gray-400 hover:text-green-600 transition-colors"
                                            title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>
                                        <!-- Edit Button -->
                                        <button class="text-gray-400 hover:text-blue-600 transition-colors"
                                            title="Edit Pesanan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        <!-- Delete Button -->
                                        <button class="text-gray-400 hover:text-red-600 transition-colors"
                                            title="Hapus Pesanan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
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

            <!-- Pagination -->
            <x-admin.pagination data="filteredOrders" />
        </div>
    </div>

    <script>
        function orderManagement() {
            return {
                // Sample data
                orders: [
                    {
                        id: '#ORD1021',
                        customer: 'Ahmad Rizki',
                        date: '15/01/2025',
                        total: 250000,
                        status: 'Menunggu Pembayaran'
                    },
                    {
                        id: '#ORD1022',
                        customer: 'Siti Nurhaliza',
                        date: '15/01/2025',
                        total: 450000,
                        status: 'Diproses'
                    },
                    {
                        id: '#ORD1023',
                        customer: 'Budi Santoso',
                        date: '14/01/2025',
                        total: 180000,
                        status: 'Dikirim'
                    },
                    {
                        id: '#ORD1024',
                        customer: 'Maya Sari',
                        date: '14/01/2025',
                        total: 320000,
                        status: 'Selesai'
                    },
                    {
                        id: '#ORD1025',
                        customer: 'Andi Pratama',
                        date: '13/01/2025',
                        total: 125000,
                        status: 'Dibatalkan'
                    },
                    {
                        id: '#ORD1026',
                        customer: 'Dewi Lestari',
                        date: '13/01/2025',
                        total: 380000,
                        status: 'Menunggu Pembayaran'
                    },
                    {
                        id: '#ORD1027',
                        customer: 'Rudi Hermawan',
                        date: '12/01/2025',
                        total: 275000,
                        status: 'Diproses'
                    },
                    {
                        id: '#ORD1028',
                        customer: 'Lina Marlina',
                        date: '12/01/2025',
                        total: 195000,
                        status: 'Selesai'
                    }
                ],

                // Filter states
                searchQuery: '',
                statusFilter: '',
                sortBy: 'newest',

                // Pagination states
                currentPage: 1,
                itemsPerPage: 3,
                filteredOrders: [],

                init() {
                    this.filteredOrders = this.orders;
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
                            order.id.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                            order.customer.toLowerCase().includes(this.searchQuery.toLowerCase())
                        );
                    }

                    // Status filter
                    if (this.statusFilter) {
                        filtered = filtered.filter(order => order.status === this.statusFilter);
                    }

                    // Sort
                    switch (this.sortBy) {
                        case 'newest':
                            filtered.sort((a, b) => new Date(b.date.split('/').reverse().join('-')) - new Date(a.date.split('/').reverse().join('-')));
                            break;
                        case 'oldest':
                            filtered.sort((a, b) => new Date(a.date.split('/').reverse().join('-')) - new Date(b.date.split('/').reverse().join('-')));
                            break;
                        case 'highest':
                            filtered.sort((a, b) => b.total - a.total);
                            break;
                        case 'lowest':
                            filtered.sort((a, b) => a.total - b.total);
                            break;
                    }

                    this.filteredOrders = filtered;
                    this.currentPage = 1;
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

                formatCurrency(amount) {
                    return 'Rp ' + amount.toLocaleString('id-ID');
                },

                getStatusClass(status) {
                    switch (status) {
                        case 'Menunggu Pembayaran':
                            return 'bg-yellow-100 text-yellow-800';
                        case 'Diproses':
                            return 'bg-blue-100 text-blue-800';
                        case 'Dikirim':
                            return 'bg-green-100 text-green-800';
                        case 'Selesai':
                            return 'bg-green-100 text-green-800';
                        case 'Dibatalkan':
                            return 'bg-red-100 text-red-800';
                        default:
                            return 'bg-gray-100 text-gray-800';
                    }
                }
            }
        }
    </script>

@endsection