@extends('layouts.layout')

@section('title')
    <title>Keranjang</title>
@endsection

@section('main')

    @php
        $cartItem = ['asd'];
    @endphp

    @if (empty($cartItem))
        <div class="min-h-screen flex justify-center items-center">
            <x-empty-cart />
        </div>
    @else
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <!-- Cart Header -->
                <div class="bg-green-500 text-white">
                    <div class="grid grid-cols-12 gap-4 px-6 py-4 font-semibold">
                        <div class="col-span-1">
                            <input type="checkbox" id="select-all" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
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
                    @forelse($cartItems ?? [
                        ['id' => 1, 'name' => 'Lorem Ipsum', 'price' => 280000, 'quantity' => 1, 'image' => null],
                        ['id' => 2, 'name' => 'Produk Kedua', 'price' => 150000, 'quantity' => 2, 'image' => null],
                        ['id' => 3, 'name' => 'Produk Ketiga', 'price' => 320000, 'quantity' => 1, 'image' => null]
                    ] as $item)
                    <div class="grid grid-cols-12 gap-4 px-6 py-6 items-center hover:bg-gray-50 transition-colors duration-200">
                        <!-- Checkbox -->
                        <div class="col-span-1">
                            <input type="checkbox" name="selected_items[]" value="{{ $item['id'] }}" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                        </div>

                        <!-- Product Image -->
                        <div class="col-span-2 flex justify-center">
                            @if($item['image'])
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                            @else
                                <div class="w-20 h-20 bg-gray-300 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Product Name -->
                        <div class="col-span-2">
                            <h3 class="font-medium text-gray-900">{{ $item['name'] }}</h3>
                        </div>

                        <!-- Price -->
                        <div class="col-span-2 text-center">
                            <span class="text-gray-600">Rp{{ number_format($item['price'], 0, ',', '.') }}</span>
                        </div>

                        <!-- Quantity Controls -->
                        <div class="col-span-2 flex items-center justify-center">
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button type="button" class="px-3 py-1 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-l-lg transition-colors duration-200" onclick="decreaseQuantity({{ $item['id'] }})">
                                    -
                                </button>
                                <input type="number" 
                                    id="quantity-{{ $item['id'] }}" 
                                    value="{{ $item['quantity'] }}" 
                                    min="1" 
                                    class="w-16 px-2 py-1 text-center border-0 focus:ring-0 focus:outline-none"
                                    onchange="updateQuantity({{ $item['id'] }}, this.value)">
                                <button type="button" class="px-3 py-1 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-r-lg transition-colors duration-200" onclick="increaseQuantity({{ $item['id'] }})">
                                    +
                                </button>
                            </div>
                        </div>

                        <!-- Total Price -->
                        <div class="col-span-2 text-center">
                            <span class="font-semibold text-gray-900" id="total-{{ $item['id'] }}">
                                Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Delete Action -->
                        <div class="col-span-1 text-center">
                            <button type="button" class="text-gray-400 hover:text-red-500 transition-colors duration-200" onclick="removeItem({{ $item['id'] }})">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.39.39-.39 1.024 0 1.414L6.414 17H19M7 13v4a2 2 0 002 2h8a2 2 0 002-2v-4M7 13H5"></path>
                        </svg>
                        <p class="text-lg font-medium">Keranjang Anda kosong</p>
                        <p class="mt-2">Mulai berbelanja untuk menambahkan produk ke keranjang</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="mt-8 flex justify-end">
                <div class="bg-white rounded-lg shadow-sm p-6 w-full max-w-md">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Belanja</h3>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Sub Total</span>
                            <span id="subtotal">Rp{{ number_format(array_sum(array_map(function($item) { return $item['price'] * $item['quantity']; }, $cartItems ?? [])), 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex justify-between font-semibold text-lg">
                            <span>Total</span>
                            <span id="total">Rp{{ number_format(array_sum(array_map(function($item) { return $item['price'] * $item['quantity']; }, $cartItems ?? [])), 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="button" class="w-full mt-6 bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    @endif

    <script>
function increaseQuantity(itemId) {
    const input = document.getElementById(`quantity-${itemId}`);
    const currentValue = parseInt(input.value);
    input.value = currentValue + 1;
    updateItemTotal(itemId);
}

function decreaseQuantity(itemId) {
    const input = document.getElementById(`quantity-${itemId}`);
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
        updateItemTotal(itemId);
    }
}

function updateQuantity(itemId, quantity) {
    if (quantity < 1) {
        document.getElementById(`quantity-${itemId}`).value = 1;
        quantity = 1;
    }
    updateItemTotal(itemId);
}

function updateItemTotal(itemId) {
    // This would typically make an AJAX call to update the server
    // For now, we'll just update the display
    const quantity = parseInt(document.getElementById(`quantity-${itemId}`).value);
    
    // You would get the price from your data or make an API call
    // This is just for demonstration
    console.log(`Updating item ${itemId} with quantity ${quantity}`);
    
    // Update subtotal and total
    updateCartSummary();
}

function removeItem(itemId) {
    if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
        // This would typically make an AJAX call to remove the item
        console.log(`Removing item ${itemId}`);
        
        // For demo purposes, you could hide the row
        // In real implementation, you'd make an API call and refresh the cart
    }
}

function updateCartSummary() {
    // This function would calculate the new totals
    // In a real application, this would be handled server-side
    console.log('Updating cart summary...');
}

// Select all functionality
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>

@endsection