@extends('layouts.layout')

@section('title')
    <title>Checkout</title>
@endsection

@section('main')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-2xl mx-auto px-4">
            <div class="bg-white rounded-lg shadow-sm p-8">
                <h1 class="text-2xl font-bold text-gray-900 text-center mb-2">Checkout Formulir</h1>
                <div class="w-20 h-0.5 bg-gray-300 mx-auto mb-8"></div>

                <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Info Pembayaran Section -->
                    <div class="mb-8">
                        <div class="bg-orange-100 border border-orange-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-orange-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-orange-800 font-medium">Info Pembayaran</span>
                            </div>
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="mb-6">
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}"
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 @error('full_name') border-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap Anda" required>
                            </div>
                            @error('full_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Detail Alamat -->
                        <div class="mb-6">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                Detail Alamat <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <textarea id="address" name="address" rows="4"
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 @error('address') border-red-500 @enderror"
                                    placeholder="Masukkan alamat lengkap Anda" required>{{ old('address') }}</textarea>
                            </div>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Detail Produk Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-700 mb-4">Detail Produk</h3>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="grid grid-cols-3 gap-4 text-sm font-medium text-gray-600 mb-4">
                                <div>Nama Barang</div>
                                <div class="text-center">Jumlah Barang</div>
                                <div class="text-right">Total Harga</div>
                            </div>

                            @forelse($orderItems ?? [['name' => 'Popok', 'quantity' => 1, 'price' => 20000]] as $item)
                                <div class="grid grid-cols-3 gap-4 py-3 border-t border-gray-200 first:border-t-0">
                                    <div class="text-gray-700">{{ $item['name'] }}</div>
                                    <div class="text-center text-gray-700">{{ $item['quantity'] }}</div>
                                    <div class="text-right text-gray-700">Rp
                                        {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-500">Tidak ada produk</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Total Pembayaran -->
                    <div class="mb-8">
                        <div class="border border-gray-300 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-medium text-gray-700">Total Pembayaran:</span>
                                <span class="text-xl font-bold text-gray-900">
                                    Rp
                                    {{ number_format(array_sum(array_map(function ($item) {
        return $item['price'] * $item['quantity']; }, $orderItems ?? [['name' => 'Popok', 'quantity' => 1, 'price' => 20000]])), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Bukti Transfer -->
                    <div class="mb-8">
                        <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Bukti Transfer <span class="text-red-500">*</span>
                        </label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="payment_proof"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                        <span>Choose File</span>
                                        <input id="payment_proof" name="payment_proof" type="file" class="sr-only"
                                            accept="image/*" required onchange="updateFileName(this)">
                                    </label>
                                    <p class="pl-1" id="file-name">No File Chosen</p>
                                </div>
                                <p class="text-xs text-gray-500">Format: JPG, JPEG, PNG (Maks. 2MB)</p>
                            </div>
                        </div>
                        @error('payment_proof')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8">
                        <button type="submit"
                            class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-4 px-6 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            Kirim Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileName = input.files[0] ? input.files[0].name : 'No File Chosen';
            document.getElementById('file-name').textContent = fileName;
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function (e) {
            const requiredFields = ['full_name', 'address', 'payment_proof'];
            let isValid = true;

            requiredFields.forEach(function (fieldName) {
                const field = document.querySelector(`[name="${fieldName}"]`);
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                } else {
                    field.classList.remove('border-red-500');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi.');
            }
        });

        // File size validation
        document.getElementById('payment_proof').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                // Check file size (2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    e.target.value = '';
                    document.getElementById('file-name').textContent = 'No File Chosen';
                    return;
                }

                // Check file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG.');
                    e.target.value = '';
                    document.getElementById('file-name').textContent = 'No File Chosen';
                    return;
                }
            }
        });
    </script>
@endsection