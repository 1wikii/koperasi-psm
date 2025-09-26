<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\Carts;
use App\Models\User;
use App\Models\UserAdresses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Carts::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('pages.product.cart', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required',
        ]);

        try {

            // cek produk sudah ada di keranjang
            $existingCartItem = Carts::where('user_id', Auth::user()->id)
                ->where('product_id', $request->input('product_id'))
                ->first();

            if ($existingCartItem) {
                return redirect()->back()->with('error', 'Produk sudah ada di keranjang.');
            }

            DB::beginTransaction();

            // Logika untuk menambahkan produk ke keranjang
            Carts::create([
                'user_id' => Auth::user()->id,
                'product_id' => $request->input('product_id'),
                'quantity' => 1, // Default quantity
                'price' => $request->input('price'),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

    }


    public function destroy($id)
    {
        $cartItem = Carts::find($id);

        if (!$cartItem || $cartItem->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Item keranjang tidak ditemukan atau Anda tidak memiliki izin untuk menghapusnya.');
        }

        try {
            DB::beginTransaction();

            $cartItem->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Item keranjang berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Bacth checkout dari keranjang
     */

    public function checkout(Request $request)
    {

        $action = $request->input('action');
        $selectedItems = $request->input('selected_items', []);
        $quantities = $request->input('quantities', []);
        $prices = $request->input('prices', []);

        // Validasi item kosong
        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Tidak ada item yang dipilih.');
        }

        switch ($action) {
            case 'delete':
                return $this->batchDelete($selectedItems);
            case 'update':
                return $this->updateQuantities($selectedItems, $quantities);
            case 'checkout':
                return $this->redirectToCheckout($selectedItems, $quantities);
            default:
                return redirect()->back()->with('error', 'Aksi tidak dikenal.');
        }
    }

    private function batchDelete(array $selectedItems)
    {
        try {
            DB::beginTransaction();

            Carts::where('user_id', Auth::id())
                ->whereIn('id', $selectedItems)
                ->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Item terpilih berhasil dihapus dari keranjang.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    private function updateQuantities(array $selectedItems, array $quantities)
    {
        try {
            DB::beginTransaction();

            foreach ($selectedItems as $itemId) {
                if (isset($quantities[$itemId])) {
                    $quantity = max(1, intval($quantities[$itemId]));


                    Carts::where('user_id', Auth::id())
                        ->where('id', $itemId)
                        ->update(['quantity' => $quantity]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Kuantitas item terpilih berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function redirectToCheckout(array $selectedItems, array $quantities)
    {

        $address = UserAdresses::where('user_id', Auth::id())->get();

        if ($address->isEmpty()) {
            return redirect()->route('user.profile.address')->with('error', 'Silakan tambahkan alamat terlebih dahulu di halaman profil sebelum melanjutkan ke checkout.');
        }

        try {
            $orderItems = Carts::with('product')
                ->where('user_id', Auth::id())
                ->whereIn('id', $selectedItems)
                ->get()
                ->map(function ($item) use ($quantities) {
                    $item->name = $item->product->name;
                    $item->price = $item->product->price;
                    $item->quantity = $quantities[$item->id] ?? $item->quantity;
                    return $item;
                })->toArray();

            // Simpan informasi alamat dan item pesanan ke session
            session(['address' => $address, 'orderItems' => $orderItems, 'cartItemIds' => $selectedItems]);

            return redirect()->route('checkout.cart');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

    }
}
