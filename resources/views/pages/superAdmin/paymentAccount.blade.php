@extends('layouts.admin-layout')

@section('title')
    <title>Manajemen Akun Bank</title>
@endsection

@section('main')
    <div class="bg-gray-50 min-h-screen">
        <div x-data="paymentAccountManager()" class="container mx-auto px-4 py-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Payment Account</h1>
                    <p class="text-gray-600">Kelola akun pembayaran sistem</p>
                </div>
                <!-- <button @click="openAddModal"
                            class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 shadow-lg rounded-lg flex items-center gap-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                                </path>
                            </svg>
                            Tambah Account
                        </button> -->
            </div>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">
                                    Nama Bank</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">
                                    Nomor Rekening</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">
                                    Nama Pemegang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <template x-for="(account, index) in accounts" :key="account.id">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                        x-text="account.bank_name"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                        x-text="account.account_number"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                        x-text="account.account_holder_name"></td>

                                    <!-- Action button -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <button @click="openEditModal(account)"
                                            class="text-green-600 hover:text-green-400 transition-colors">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        <!-- <button @click="openDeleteModal(account)"
                                                                    class="text-red-600 hover:text-red-800 transition-colors">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                        </path>
                                                                    </svg>
                                                                </button> -->
                                    </td>
                                </tr>
                            </template>

                            <!-- Empty State -->
                            <tr x-show="accounts.length === 0">
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                        </path>
                                    </svg>
                                    <p class="text-lg font-medium mb-2">Belum ada payment account</p>
                                    <p class="text-sm">Klik tombol "Tambah Account" untuk menambah data pertama</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add/Edit Modal -->
            <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
                <div x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">

                    <!-- Modal Header -->
                    <div class="bg-green-600 text-white px-6 py-4 rounded-t-lg">
                        <h3 class="text-lg font-semibold" x-text="modalTitle"></h3>
                    </div>

                    <!-- Modal Form -->
                    <form :action="formAction" method="POST" class="p-6">
                        @csrf
                        <input x-show="isEdit" type="hidden" name="_method" value="PUT">
                        <input x-show="isEdit" type="hidden" name="id" :value="editData.id">

                        <div class="space-y-4">
                            <!-- Bank Name -->
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Bank</label>
                                <input type="text" id="bank_name" name="bank_name" x-model="formData.bank_name"
                                    value="{{ old('bank_name') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="Contoh: Bank BCA" required>

                                @error('bank_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Account Number -->
                            <div>
                                <label for="account_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                                    Rekening</label>
                                <input type="text" id="account_number" name="account_number"
                                    x-model="formData.account_number" value="{{ old('account_number') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="Contoh: 1234567890" required>

                                @error('account_number')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Account Holder Name -->
                            <div>
                                <label for="account_holder_name" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Pemegang Rekening</label>
                                <input type="text" id="account_holder_name" name="account_holder_name"
                                    x-model="formData.account_holder_name" value="{{ old('account_holder_name') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="Contoh: PT. Company Name" required>
                                @error('account_holder_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                            <button type="button" @click="closeModal"
                                class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                                <span x-text="isEdit ? 'Update' : 'Simpan'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Modal -->
            <div x-show="showDeleteModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
                <div x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">

                    <!-- Modal Header -->
                    <div class="bg-red-600 text-white px-6 py-4 rounded-t-lg">
                        <h3 class="text-lg font-semibold">Konfirmasi Hapus</h3>
                    </div>

                    <!-- Modal Content -->
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <svg class="w-12 h-12 text-red-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L5.35 16.5c-.77.833.192 2.5 1.732 2.5z">
                                </path>
                            </svg>
                            <div>
                                <p class="text-lg font-medium text-gray-900 mb-2">Yakin ingin hapus?</p>
                                <p class="text-sm text-gray-600">
                                    Account: <span class="font-medium" x-text="deleteData.bank_nama"></span><br>
                                    Rekening: <span class="font-medium" x-text="deleteData.account_number"></span>
                                </p>
                            </div>
                        </div>

                        <!-- Delete Form -->
                        <form :action="'/admin/payment-accounts/' + deleteData.id" method="POST"
                            class="flex justify-end gap-3">
                            @csrf
                            @method('DELETE')

                            <button type="button" @click="closeDeleteModal"
                                class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function paymentAccountManager() {
            return {
                accounts: @json($paymentAccounts ?? []),

                // Modal States
                showModal: false,
                showDeleteModal: false,
                isEdit: false,

                // Form Data
                formData: {
                    bank_name: '',
                    account_number: '',
                    account_holder_name: ''
                },
                editData: {},
                deleteData: {},

                // Computed Properties
                get modalTitle() {
                    return this.isEdit ? 'Edit Payment Account' : 'Tambah Payment Account';
                },

                get formAction() {
                    return this.isEdit ? `/superadmin/payment-accounts/${this.editData.id}` : '/superadmin/payment-accounts';
                },

                // Methods
                openAddModal() {
                    this.isEdit = false;
                    this.resetForm();
                    this.showModal = true;
                },

                openEditModal(account) {
                    this.isEdit = true;
                    this.editData = account;
                    this.formData = { ...account };
                    this.showModal = true;
                },

                openDeleteModal(account) {
                    this.deleteData = account;
                    this.showDeleteModal = true;
                },

                closeModal() {
                    this.showModal = false;
                    setTimeout(() => {
                        this.resetForm();
                        this.editData = {};
                    }, 200);
                },

                closeDeleteModal() {
                    this.showDeleteModal = false;
                    this.deleteData = {};
                },

                resetForm() {
                    this.formData = {
                        bank_nama: '',
                        account_number: '',
                        account_holder_name: ''
                    };
                }
            }
        }
    </script>
@endsection