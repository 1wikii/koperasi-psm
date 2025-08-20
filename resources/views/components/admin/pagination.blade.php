@props(['data'])

<div class="bg-white px-6 py-3 border-t border-gray-200 flex items-center justify-between">
    <div class="text-sm text-gray-500">
        Menampilkan <span class="me-1" x-text="((currentPage - 1) * itemsPerPage) + 1"></span>ke <span
            x-text="Math.min(currentPage * itemsPerPage, {{ $data }}.length)"></span> dari <span
            x-text="{{ $data }}.length"></span>
        kategori
    </div>
    <div class="relative">
        <select x-model="itemsPerPage"
            class="w-14 appearance-none bg-white border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-colors">
            <option value="3">3</option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>
    <div class="flex items-center space-x-2">
        <button @click="previousPage" :disabled="currentPage === 1"
            :class="currentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:text-green-600'"
            class="px-3 py-1 text-sm transition-colors">
            Sebelumnya
        </button>

        <template x-for="page in getPageNumbers()" :key="page">
            <button @click="goToPage(page)"
                :class="page === currentPage ? 'bg-green-600 text-white' : 'text-gray-500 hover:text-green-600'"
                class="px-3 py-1 text-sm rounded transition-colors" x-text="page"></button>
        </template>

        <button @click="nextPage" :disabled="currentPage === totalPages"
            :class="currentPage === totalPages ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:text-green-600'"
            class="px-3 py-1 text-sm transition-colors">
            Selanjutnya
        </button>
    </div>
</div>