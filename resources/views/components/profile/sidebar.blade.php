<!-- Sidebar -->
<div class="w-64 bg-white rounded-lg shadow-sm p-6">
    <nav class="space-y-2">
        <button @click="currentPage = 'profile'"
            :class="currentPage === 'profile' ? 'bg-green-50 text-green-600 border-green-200' : 'text-gray-700 hover:bg-gray-50'"
            class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md border border-transparent">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Profile
        </button>

        <button @click="currentPage = 'alamat'"
            :class="currentPage === 'alamat' ? 'bg-green-50 text-green-600 border-green-200' : 'text-gray-700 hover:bg-gray-50'"
            class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md border border-transparent">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Alamat
        </button>

        <button @click="currentPage = 'pesanan'"
            :class="currentPage === 'pesanan' ? 'bg-green-50 text-green-600 border-green-200' : 'text-gray-700 hover:bg-gray-50'"
            class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md border border-transparent">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 11V7a4 4 0 00-8 0v4M8 11v6h8v-6M8 11H6a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2h-2">
                </path>
            </svg>
            Pesanan
        </button>
    </nav>
</div>