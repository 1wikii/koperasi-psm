@extends('layouts.admin-layout')

@section('title')
    <title>Manajemen Produk</title>
@endsection

@section('main')
    <div x-data="productManager()" class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Kelola Produk</h1>
        </div>

        <!-- Search and Filters -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <!-- Search Input -->
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" x-model="searchQuery" @input="filterProducts" placeholder="Cari produk..."
                    class="shadow-lg w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-colors">
            </div>

            <!-- Category Filter -->
            <div class="relative">
                <select x-model="categoryFilter" @change="filterProducts"
                    class="shadow-lg appearance-none bg-white border border-gray-300 rounded-lg px-4 py-3 pr-10 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-colors min-w-48">
                    <option value="">Semua Kategori</option>
                    <option value="elektronik">Elektronik</option>
                    <option value="fashion">Fashion</option>
                    <option value="makanan">Makanan</option>
                    <option value="kecantikan">Kecantikan</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            <!-- Sort Filter -->
            <div class="relative">
                <select x-model="sortFilter" @change="filterProducts"
                    class="shadow-lg appearance-none bg-white border border-gray-300 rounded-lg px-4 py-3 pr-10 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-colors min-w-32">
                    <option value="terbaru">Terbaru</option>
                    <option value="terlama">Terlama</option>
                    <option value="harga_rendah">Harga Terendah</option>
                    <option value="harga_tinggi">Harga Tertinggi</option>
                    <option value="nama_az">Nama A-Z</option>
                    <option value="nama_za">Nama Z-A</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            <!-- Add Button -->
            <button x-on:click="showAddModal = true"
                class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 shadow-lg rounded-lg flex items-center gap-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Tambah Produk
            </button>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr class="text-gray-900">
                            <th class="px-6 py-4 text-left text-sm font-semibold">Gambar</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Nama Produk</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Harga</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Stok</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <template x-for="product in paginatedProducts" :key="product.id">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <!-- Product Image -->
                                <td class="px-6 py-4">
                                    <div
                                        class="w-12 h-12 bg-gray-300 rounded-lg flex items-center justify-center text-gray-600 font-semibold text-sm">
                                        <span x-text="product.id"></span>
                                    </div>
                                </td>

                                <!-- Product Name -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900" x-text="product.name"></div>
                                </td>

                                <!-- Price -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900" x-text="formatPrice(product.price)"></div>
                                </td>

                                <!-- Stock -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900" x-text="product.stock"></div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                        :class="getStatusClass(product.status)" x-text="product.status">
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <!-- Edit Button -->
                                        <button type="button" @click="selectedProduct = product; showEditModal = true"
                                            class="text-gray-400 hover:text-blue-600 transition-colors p-1 rounded"
                                            title="Edit Kategori">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button" onclick=""
                                            class="text-gray-400 hover:text-red-600 transition-colors p-1 rounded"
                                            title="Hapus Kategori">
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
            <x-admin.empty-table data="filteredProducts" />

            <!-- Pagination -->
            <x-admin.pagination data="filteredProducts" />
        </div>

        <!-- Add Modal -->
        <x-admin.modal.product.product-modal show="showAddModal" categories="categories" />

        <!-- Edit Modal -->
        <x-admin.modal.product.product-modal-edit show="showEditModal" categories="categories" id="selectedProduct?.id"
            name="selectedProduct?.name" price="selectedProduct?.price" stock="selectedProduct?.stock"
            status="selectedProduct?.status" category="selectedProduct?.category"
            description="selectedProduct?.description" />

    </div>

    <script>
        function productManager() {
            return {
                // mock data Categories
                categories: [
                    { id: 1, name: 'Elektronik', products_count: 10, status: 'Aktif' },
                    { id: 2, name: 'Fashion', products_count: 5, status: 'Nonaktif' },
                    { id: 3, name: 'Makanan', products_count: 8, status: 'Aktif' },
                    { id: 4, name: 'Kecantikan', products_count: 12, status: 'Nonaktif' },
                    { id: 5, name: 'Olahraga', products_count: 7, status: 'Aktif' },
                    { id: 6, name: 'Peralatan Rumah', products_count: 15, status: 'Nonaktif' },
                    { id: 7, name: 'Buku', products_count: 20, status: 'Aktif' },
                    { id: 8, name: 'Mainan', products_count: 10, status: 'Nonaktif' },
                ],


                // filters
                searchQuery: '',
                categoryFilter: '',
                sortFilter: 'terbaru',
                products: [
                    { id: 'P1', name: 'Xiaomi GT2', price: 199000, stock: 25, status: 'Aktif', category: 'elektronik', description: 'Newest smartphone of xiaomi', status: 'Aktif', date: '12/01/2025', },
                    { id: 'P2', name: 'Sepatu', price: 299000, stock: 0, status: 'Habis', category: 'fashion', description: 'Stylish running shoes', status: 'Nonaktif', date: '11/01/2025' },
                    { id: 'P3', name: 'Chitato', price: 399000, stock: 15, status: 'Aktif', category: 'makanan', description: 'Delicious potato chips', status: 'Aktif', date: '10/01/2025' },
                    { id: 'P4', name: 'Suncreen spa 50++', price: 159000, stock: 8, status: 'Nonaktif', category: 'kecantikan', description: 'High protection sunscreen', status: 'Nonaktif', date: '09/01/2025' },
                    { id: 'P5', name: 'Xiaomi Mi Band 6', price: 459000, stock: 32, status: 'Aktif', category: 'elektronik', description: 'Fitness tracker with AMOLED display', status: 'Aktif', date: '08/01/2025' },
                ],

                // Pagination states
                currentPage: 1,
                itemsPerPage: 3,
                filteredProducts: [],

                // Modal states
                showAddModal: false,
                showEditModal: false,
                selectedProduct: null,

                // pagination 
                get init() {
                    this.filteredProducts = this.products;
                },

                get filterProducts() {
                    let filtered = this.products;

                    // Filter by search query
                    if (this.searchQuery) {
                        filtered = filtered.filter(product =>
                            product.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                            product.id.toLowerCase().includes(this.searchQuery.toLowerCase())
                        );
                    }

                    // Filter by category
                    if (this.categoryFilter) {
                        filtered = filtered.filter(product => product.category === this.categoryFilter);
                    }

                    // Sort products
                    switch (this.sortFilter) {
                        case 'terbaru':
                            filtered.sort((a, b) => new Date(b.date.split('/').reverse().join('-')) - new Date(a.date.split('/').reverse().join('-')));
                            break;
                        case 'terlama':
                            filtered.sort((a, b) => new Date(a.date.split('/').reverse().join('-')) - new Date(b.date.split('/').reverse().join('-')));
                            break;
                        case 'harga_rendah':
                            filtered.sort((a, b) => a.price - b.price);
                            break;
                        case 'harga_tinggi':
                            filtered.sort((a, b) => b.price - a.price);
                            break;
                        case 'nama_az':
                            filtered.sort((a, b) => a.name.localeCompare(b.name));
                            break;
                        case 'nama_za':
                            filtered.sort((a, b) => b.name.localeCompare(a.name));
                            break;
                    }

                    this.filteredProducts = filtered;
                    this.currentPage = 1; // Reset to first page after filtering
                },

                get paginatedProducts() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;
                    return this.filteredProducts.slice(start, end);
                },

                get totalPages() {
                    return Math.ceil(this.filteredProducts.length / this.itemsPerPage);
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


                sortProducts(products) {
                    const sorted = [...products];

                    switch (this.sortFilter) {
                        case 'terbaru':
                            return sorted.reverse();
                        case 'terlama':
                            return sorted;
                        case 'harga_rendah':
                            return sorted.sort((a, b) => a.price - b.price);
                        case 'harga_tinggi':
                            return sorted.sort((a, b) => b.price - a.price);
                        case 'nama_az':
                            return sorted.sort((a, b) => a.name.localeCompare(b.name));
                        case 'nama_za':
                            return sorted.sort((a, b) => b.name.localeCompare(a.name));
                        default:
                            return sorted;
                    }
                },

                formatPrice(price) {
                    return 'Rp ' + price.toLocaleString('id-ID');
                },

                getStatusClass(status) {
                    if (status == "Aktif") {
                        return 'bg-green-100 text-green-800';
                    } else if (status == "Habis") {
                        return 'bg-red-100 text-red-800';
                    } else if (status == "Nonaktif") {
                        return 'bg-gray-100 text-gray-800';
                    }
                }
            }
        }
    </script>
@endsection