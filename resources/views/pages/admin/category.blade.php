@extends('layouts.admin-layout')

@section('title')
    <title>Category Management</title>
@endsection

@section('main')
    <div class="min-h-screen bg-gray-50 p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Kelola Kategori</h1>
            </div>

            <!-- Search Bar -->
            <div class="mb-6">
                <div class="relative max-w-md">
                    <input type="text" id="search-categories" name="search" placeholder="Cari kategori..."
                        class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white shadow-sm"
                        value="{{ request('search') }}">
                    <button type="submit"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <!-- Table Header -->
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="grid grid-cols-12 gap-4 font-medium text-gray-700">
                        <div class="col-span-4">
                            <span>Nama Kategori</span>
                        </div>
                        <div class="col-span-3">
                            <span>Jumlah Produk</span>
                        </div>
                        <div class="col-span-3">
                            <span>Status</span>
                        </div>
                        <div class="col-span-2">
                            <span>Aksi</span>
                        </div>
                    </div>
                </div>

                <!-- Table Body -->
                <div class="divide-y divide-gray-200">
                    @forelse($categories ?? [collect(['id' => 1, 'name' => 'Buku & Alat Tulis', 'products_count' => 15, 'status' => 'active'])] as $category)

                        <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                            <div class="grid grid-cols-12 gap-4 items-center">
                                <!-- Category Name -->
                                <div class="col-span-4">
                                    <span class="text-gray-900 font-medium">
                                        {{ $category['name'] }}
                                    </span>
                                </div>

                                <!-- Product Count -->
                                <div class="col-span-3">
                                    <span class="text-gray-600">
                                        {{  $category['products_count']  }}
                                        produk
                                    </span>
                                </div>

                                <!-- Status -->
                                <div class="col-span-3">
                                    @php
                                        $status = $category['status'];
                                        $isActive = $status === 'active';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $isActive ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>

                                <!-- Actions -->
                                <div class="col-span-2">
                                    <div class="flex items-center space-x-3">
                                        <!-- Edit Button -->
                                        <button type="button" onclick="editCategory({{ $category['id'] }})"
                                            class="text-gray-400 hover:text-blue-600 transition-colors p-1 rounded"
                                            title="Edit Kategori">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button" onclick="deleteCategory({{ $category['id'] }})"
                                            class="text-gray-400 hover:text-red-600 transition-colors p-1 rounded"
                                            title="Hapus Kategori">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center">
                            <div class="text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                                <p class="text-lg font-medium mb-2">Tidak ada kategori</p>
                                <p class="text-gray-400">Belum ada kategori yang ditambahkan</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination (if needed) -->
            @if(isset($categories) && method_exists($categories, 'links'))
                <div class="mt-6">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- JavaScript for interactions -->
    <script>
        function editCategory(categoryId) {
            // Implement edit functionality
            console.log('Edit category:', categoryId);
            // You can redirect to edit page or open a modal
            // window.location.href = `/categories/${categoryId}/edit`;
        }

        function deleteCategory(categoryId) {
            if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
                // Implement delete functionality
                console.log('Delete category:', categoryId);
                // You can send AJAX request or submit a form
                // fetch(`/categories/${categoryId}`, { method: 'DELETE' })...
            }
        }

        // Search functionality
        document.getElementById('search-categories').addEventListener('input', function (e) {
            // Implement live search or form submission
            // You can debounce this for better performance
            console.log('Search:', e.target.value);
        });
    </script>
@endsection