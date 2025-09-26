@extends('layouts.layout')

@section('title')
    <title>Keranjang</title>
@endsection

@section('main')

    @if ($cartItems->isEmpty())
        <div class="min-h-screen flex items-center justify-center">
            <x-empty-cart />
        </div>
    @else
        <form id="cart-form" action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            @method('POST')
            <div class="container mx-auto px-4 py-8">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <!-- Cart Header -->
                    <div class="bg-green-500 text-white">
                        <div class="grid grid-cols-12 gap-4 px-6 py-4 font-semibold">
                            <div class="col-span-1">
                                <input type="checkbox" id="select-all"
                                    class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                                <label for="select-all" class="ml-2 text-sm">SEMUA</label>
                            </div>
                            <div class="col-span-2 text-center">PRODUK</div>
                            <div class="col-span-2 text-center">NAMA</div>
                            <div class="col-span-2 text-center">HARGA</div>
                            <div class="col-span-2 text-center">JUMLAH</div>
                            <div class="col-span-2 text-center">TOTAL</div>
                            <div class="col-span-1 text-center">AKSI</div>
                        </div>
                    </div>

                    <!-- Cart Items -->
                    <div class="divide-y divide-gray-200">
                        @foreach($cartItems as $item)
                            <div
                                class="grid grid-cols-12 gap-4 px-6 py-6 items-center hover:bg-gray-50 transition-colors duration-200">
                                <!-- Checkbox -->
                                <div class="col-span-1">
                                    <input type="checkbox" name="selected_items[]" value="{{ $item['id'] }}"
                                        class="item-checkbox w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2"
                                        data-price="{{ $item->product->price }}" data-quantity="{{ $item->quantity }}"
                                        data-item-id="{{ $item->id }}">
                                </div>

                                <!-- Product Image -->
                                <div class="col-span-2 flex justify-center">
                                    @if($item->product->images)
                                        <img src="{{ $item->product->images }}" alt="{{ $item->product->name }}"
                                            class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                                    @else
                                        <div class="w-20 h-20 bg-gray-300 rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Name -->
                                <div class="col-span-2">
                                    <h3 class="font-medium text-gray-900">{{ $item->product->name }}</h3>
                                </div>

                                <!-- Price -->
                                <input type="hidden" name="prices[{{ $item->id }}]" value="{{ $item->product->price }}">
                                <div class="col-span-2 text-center">
                                    <span class="text-gray-600">Rp{{ number_format($item->product->price, 0, ',', '.') }}</span>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="col-span-2 flex flex-col items-center justify-center">

                                    <!-- Stock -->
                                    <div class="text-sm text-gray-500 italic mb-1">
                                        Stok : {{ $item->product->stock }}
                                    </div>

                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button type="button"
                                            class="px-3 py-1 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-l-lg transition-colors duration-200"
                                            onclick="decreaseQuantity({{ $item['id'] }})">
                                            -
                                        </button>
                                        <input type="number" id="quantity-{{ $item->id }}" name="quantities[{{ $item->id }}]"
                                            value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                            class="quantity-input w-16 px-2 py-1 text-center border-0 focus:ring-0 focus:outline-none"
                                            data-item-id="{{ $item->id }}" data-price="{{ $item->product->price }}"
                                            onchange="updateQuantity({{ $item->id }}, this.value)">
                                        <button type="button"
                                            class="px-3 py-1 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-r-lg transition-colors duration-200"
                                            onclick="increaseQuantity({{ $item['id'] }}, {{ $item->product->stock }})">
                                            +
                                        </button>
                                    </div>
                                </div>

                                <!-- Total Price -->
                                <div class="col-span-2 text-center">
                                    <span class="font-semibold text-gray-900" id="total-{{ $item->id }}">
                                        Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                    </span>
                                </div>

                                <!-- Delete Action -->
                                <div class="col-span-1 text-center">
                                    <button type="button" onclick="deleteItem('{{ route('cart.destroy', $item->id) }}')"
                                        class="text-gray-400 hover:text-red-500 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Batch Actions -->
                <div class="mt-6 flex gap-4">
                    <button type="submit" name="action" value="delete"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors duration-200"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus item yang dipilih?')">
                        Hapus Terpilih
                    </button>

                    <button type="submit" name="action" value="update"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors duration-200">
                        Update Terpilih
                    </button>
                </div>

                <!-- Cart Summary -->
                <div class="mt-8 flex justify-end">
                    <div class="bg-white rounded-lg shadow-sm p-6 w-full max-w-md">
                        <div class="border-t pt-4">
                            <div class="flex justify-between font-semibold text-lg">
                                <span>Total</span>
                                <span>Rp.<span id="total-selected">0</span></span>

                            </div>
                        </div>

                        <button id="checkout-button" type="submit" name="action" value="checkout"
                            class="w-full mt-6 bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Form hapus menghindari nested form -->
        <form id="delete-form" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    @endif
    <script>
        function deleteItem(actionUrl) {
            if (confirm('Apakah Anda yakin ingin menghapus item yang dipilih ? ')) {
                const form = document.getElementById('delete-form');
                form.action = actionUrl;
                form.submit();
            }
        }

        function increaseQuantity(itemId, max) {
            const input = document.getElementById(`quantity-${itemId}`);
            const currentValue = parseInt(input.value);
            if (currentValue < max) {
                input.value = currentValue + 1;
                updateItemTotal(itemId);
                updateSelectedTotal();
            }
        }

        function decreaseQuantity(itemId) {
            const input = document.getElementById(`quantity-${itemId}`);
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateItemTotal(itemId);
                updateSelectedTotal();
            }
        }

        function updateQuantity(itemId, quantity) {
            if (quantity < 1) {
                document.getElementById(`quantity-${itemId}`).value = 1;
                quantity = 1;
            }
            updateItemTotal(itemId);
            updateSelectedTotal();
        }

        function updateItemTotal(itemId) {
            const quantityInput = document.getElementById(`quantity-${itemId}`);
            const quantity = parseInt(quantityInput.value);
            const price = parseFloat(quantityInput.dataset.price);
            const total = price * quantity;

            document.getElementById(`total-${itemId}`).textContent =
                'Rp' + total.toLocaleString('id-ID');

            // Update checkbox data
            const checkbox = document.querySelector(`input[data-item-id="${itemId}"]`);
            if (checkbox) {
                checkbox.dataset.quantity = quantity;
            }
        }

        function updateSelectedTotal() {
            const selectedCheckboxes = document.querySelectorAll('.item-checkbox:checked');
            let total = 0;

            selectedCheckboxes.forEach(checkbox => {
                const price = parseFloat(checkbox.dataset.price);
                const quantity = parseInt(checkbox.dataset.quantity);
                total += price * quantity;
            });

            document.getElementById('total-selected').textContent = total.toLocaleString('id-ID');

            // ✅ Enable/disable tombol checkout
            // document.getElementById('checkout-button').disabled = selectedCheckboxes.length === 0;
        }

        // Select all functionality
        document.getElementById('select-all').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedTotal();
        });

        // Individual checkbox change
        document.querySelectorAll('.item-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                updateSelectedTotal();

                // Update select-all checkbox
                const allCheckboxes = document.querySelectorAll('.item-checkbox');
                const checkedCheckboxes = document.querySelectorAll('.item-checkbox:checked');
                document.getElementById('select-all').checked =
                    allCheckboxes.length === checkedCheckboxes.length;
            });
        });

        // Quantity input change
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function () {
                const itemId = this.dataset.itemId;
                const quantity = parseInt(this.value);

                // Update checkbox data
                const checkbox = document.querySelector(`input[data-item-id="${itemId}"]`);
                if (checkbox) {
                    checkbox.dataset.quantity = quantity;
                }

                updateSelectedTotal();
            });
        });

        // Initial calculation
        document.addEventListener('DOMContentLoaded', function () {
            updateSelectedTotal();
        });
    </script>

@endsection