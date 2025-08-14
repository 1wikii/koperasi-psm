@extends('layouts.layout')

@section('title')
    <title>Alamat Pengiriman</title>

@endsection

@section('main')
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Daftar Alamat</h1>

            <!-- Add Address Button -->
            <button type="button"
                class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                onclick="openAddressModal()">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Alamat
            </button>
        </div>

        <!-- Address Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Table Header -->
            <div class="bg-green-500 text-white">
                <div class="grid grid-cols-12 gap-4 px-6 py-4 font-semibold">
                    <div class="col-span-1">NO</div>
                    <div class="col-span-3">NAMA</div>
                    <div class="col-span-3">NO HANDPHONE</div>
                    <div class="col-span-5">ALAMAT</div>
                </div>
            </div>

            <!-- Table Body -->
            <div class="divide-y divide-gray-200">
                @forelse($addresses ?? [] as $index => $address)
                    <div class="grid grid-cols-12 gap-4 px-6 py-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="col-span-1 text-gray-700">{{ $index + 1 }}</div>
                        <div class="col-span-3 text-gray-700">{{ $address['name'] ?? '-' }}</div>
                        <div class="col-span-3 text-gray-700">{{ $address['phone'] ?? '-' }}</div>
                        <div class="col-span-5 text-gray-700">{{ $address['full_address'] ?? '-' }}</div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <p class="text-lg font-medium">Belum ada alamat tersimpan</p>
                        <p class="mt-2">Tambahkan alamat baru untuk memudahkan pengiriman</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Add Address Modal -->
    <div id="addressModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-lg bg-white">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-gray-900">Daftar Alamat Pengirim</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors duration-200"
                    onclick="closeAddressModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('addresses.store') }}" method="POST" id="addressForm">
                @csrf

                <!-- Label Alamat -->
                <div class="mb-6">
                    <label for="label" class="block text-sm font-medium text-gray-700 mb-2">
                        Label Alamat <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" id="label" name="label" maxlength="20"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                            placeholder="Tambahkan label seperti: Rumah, Kantor, dsb." required>
                        <div class="absolute right-3 top-2 text-sm text-gray-400">
                            <span id="labelCount">0</span>/20
                        </div>
                    </div>
                </div>

                <!-- Phone and Name Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Phone Number -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="phone" name="phone"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                            placeholder="Masukkan nomor telepon penerima paket" required>
                    </div>

                    <!-- Recipient Name -->
                    <div>
                        <label for="recipient_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Penerima <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="recipient_name" name="recipient_name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                            placeholder="Masukkan nama penerima paket" required>
                    </div>
                </div>

                <!-- District and Subdistrict Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- District -->
                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-2">
                            Kecamatan <span class="text-red-500">*</span>
                        </label>
                        <select id="district" name="district"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                            required>
                            <option value="">Pilih kecamatan kamu</option>
                            <option value="kedaton">Kedaton</option>
                            <option value="rajabasa">Rajabasa</option>
                            <option value="tanjungkarang">Tanjungkarang Pusat</option>
                            <option value="telukbetung">Telukbetung Utara</option>
                        </select>
                    </div>

                    <!-- Subdistrict -->
                    <div>
                        <label for="subdistrict" class="block text-sm font-medium text-gray-700 mb-2">
                            Kelurahan <span class="text-red-500">*</span>
                        </label>
                        <select id="subdistrict" name="subdistrict"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                            required>
                            <option value="">Pilih kelurahan kamu</option>
                            <option value="kedamaian">Kedamaian</option>
                            <option value="korpri">Korpri</option>
                            <option value="labuhan_dalam">Labuhan Dalam</option>
                        </select>
                    </div>
                </div>

                <!-- Province and Regency Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Province -->
                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700 mb-2">
                            Provinsi
                        </label>
                        <input type="text" id="province" name="province" value="Lampung"
                            class="w-full px-3 py-2 bg-gray-200 border border-gray-300 rounded-lg cursor-not-allowed"
                            readonly>
                    </div>

                    <!-- Regency -->
                    <div>
                        <label for="regency" class="block text-sm font-medium text-gray-700 mb-2">
                            Kabupaten
                        </label>
                        <input type="text" id="regency" name="regency" value="Way Kanan"
                            class="w-full px-3 py-2 bg-gray-200 border border-gray-300 rounded-lg cursor-not-allowed"
                            readonly>
                    </div>
                </div>

                <!-- Postal Code and Detail Address Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Postal Code -->
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                            Kode Pos <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="postal_code" name="postal_code"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                            placeholder="Kode pos alamat kamu" required>
                    </div>

                    <!-- Detail Address -->
                    <div>
                        <label for="detail_address" class="block text-sm font-medium text-gray-700 mb-2">
                            Detail Alamat <span class="text-red-500">*</span>
                        </label>
                        <textarea id="detail_address" name="detail_address" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 resize-none"
                            placeholder="Berikan detail nama jalan, patokan, alamat, dsb." required></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Modal Functions
        function openAddressModal() {
            document.getElementById('addressModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeAddressModal() {
            document.getElementById('addressModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('addressForm').reset();
            updateLabelCount();
        }

        // Label character counter
        function updateLabelCount() {
            const label = document.getElementById('label');
            const count = document.getElementById('labelCount');
            count.textContent = label.value.length;
        }

        document.getElementById('label').addEventListener('input', updateLabelCount);

        // Close modal when clicking outside
        document.getElementById('addressModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeAddressModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeAddressModal();
            }
        });

        // Phone number validation (only numbers)
        document.getElementById('phone').addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Postal code validation (only numbers)
        document.getElementById('postal_code').addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Form validation
        document.getElementById('addressForm').addEventListener('submit', function (e) {
            const requiredFields = ['label', 'phone', 'recipient_name', 'district', 'subdistrict', 'postal_code', 'detail_address'];
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
                return false;
            }

            // Phone number validation
            const phone = document.getElementById('phone').value;
            if (phone.length < 10 || phone.length > 15) {
                e.preventDefault();
                alert('Nomor telepon harus antara 10-15 digit.');
                document.getElementById('phone').classList.add('border-red-500');
                return false;
            }

            // Postal code validation
            const postalCode = document.getElementById('postal_code').value;
            if (postalCode.length !== 5) {
                e.preventDefault();
                alert('Kode pos harus 5 digit.');
                document.getElementById('postal_code').classList.add('border-red-500');
                return false;
            }
        });

        // Initialize character counter on page load
        document.addEventListener('DOMContentLoaded', function () {
            updateLabelCount();
        });
    </script>
@endsection