@extends('layouts.admin-layout')

@section('title')
    <title>Manajemen Kategori</title>
@endsection

@section('main')
    <div x-data="categoryManager()" class="min-h-screen bg-gray-50 p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Kelola Kategori</h1>
            </div>

            <!-- Search Bar -->
            <div class="mb-6 flex justify-between gap-x-4">
                <div class="flex-1">
                    <input type="text" x-model="searchQuery" @input="filterCategories" placeholder="Cari kategori..."
                        class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white shadow-lg">
                </div>

                <!-- Add Button -->
                <button x-on:click="openAddModal()"
                    class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 shadow-lg rounded-lg flex items-center gap-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                        </path>
                    </svg>
                    Tambah Kategori
                </button>
            </div>

            <!-- Categories Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <!-- Table Header -->
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr class="text-gray-900">
                                <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    <span>Nama Kategori</span>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    <span>Jumlah Produk</span>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    <span>Status</span>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                    <span>Aksi</span>
                                </th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="bg-white divide-y divide-gray-200">

                            <template x-for="category in paginatedCategories" :key="category.id">
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-gray-900 font-medium" x-text="category.name">
                                            <!-- category.name -->
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-gray-900 font-medium" x-text="category.products_count">
                                            <!-- category.products_count -->
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full"
                                            :class="getStatusClass(category.status)" x-text="category.status">
                                            <!-- category.status -->
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <!-- Edit Button -->
                                            <button type="button" @click="selectedCategory = category; showEditModal = true"
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
            </div>

            <!-- Empty State -->
            <x-admin.empty-table data="filteredCategories" />

            <!-- Pagination -->
            <x-admin.pagination data="filteredCategories" />
        </div>

        <!-- Add Modal -->
        <x-admin.modal.category.category-modal show="showAddModal" />

        <!-- Edit Modal -->
        <x-admin.modal.category.category-modal-edit show="showEditModal" id="selectedCategory?.id"
            name="selectedCategory?.name" status="selectedCategory?.status" />

    </div>

    <!-- JavaScript for interactions -->
    <script>
        function categoryManager() {
            return {
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

                searchQuery: '',

                // Pagination states
                currentPage: 1,
                itemsPerPage: 3,
                filteredCategories: [], // This will hold the filtered categories

                // Modal States
                showAddModal: false,
                showEditModal: false,
                selectedCategory: null,

                init() {
                    this.filteredCategories = this.categories;
                },

                get paginatedCategories() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;
                    return this.filteredCategories.slice(start, end);
                },

                filterCategories() {
                    let filtered = this.categories;

                    if (this.searchQuery) {
                        filtered = filtered.filter(category =>
                            category.name.toLowerCase().includes(this.searchQuery.toLowerCase())
                        );
                    }
                    this.filteredCategories = filtered;
                },

                get totalPages() {
                    return Math.ceil(this.filteredCategories.length / this.itemsPerPage);
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

                getStatusClass(status) {
                    switch (status) {
                        case 'Aktif':
                            return 'bg-green-100 text-green-800';
                        case 'Nonaktif':
                            return 'bg-red-100 text-red-800';
                    }
                },


                // Modal Handler
                openAddModal() {
                    this.showEditModal = false;
                    this.showAddModal = true;
                },

                openEditModal() {
                    this.showAddModal = false;
                    this.showEditModal = true;
                }
            }
        }

    </script>
@endsection