<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Payments;
use App\Models\Products;
use App\Models\UserAdresses;
use App\Services\FileUploadservice;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkoutCart()
    {
        $address = session('address', []);
        $orderItems = session('orderItems', []);
        $cartItemIds = session('cartItemIds', []);
        $paymentAccounts = \App\Models\PaymentAccounts::where('is_active', true)->first();

        return view('pages.product.checkout', compact('address', 'orderItems', 'paymentAccounts'));
    }

    public function checkout(Request $request)
    {
        $product_id = $request->input('product_id');

        // cek user punya alamat atau tidak
        $userAddressCount = UserAdresses::where('user_id', Auth::id())->count();
        if ($userAddressCount == 0) {
            return redirect()->route('user.profile.address')->with('error', 'Silakan tambahkan alamat terlebih dahulu sebelum checkout.');
        }

        $address = UserAdresses::where('user_id', Auth::id())->get();
        $orderItems = Products::where('id', $product_id)->get()->map(function ($product) {
            return [
                'product_id' => $product['id'],
                'name' => $product['name'],
                'quantity' => 1,
                'price' => $product['price'],
            ];
        })->toArray();

        $paymentAccounts = \App\Models\PaymentAccounts::where('is_active', true)->first();
        return view('pages.product.checkout', compact('address', 'orderItems', 'paymentAccounts'));
    }


    public function checkoutProcess(Request $request)
    {
        $request->validate([
            'sender_name' => 'required',
            'address' => 'required',
            'order_items' => 'required|json',
            'total_amount' => 'required',
            'payment_proof' => 'image|max:2048', // Contoh validasi untuk bukti pembayaran
        ]);

        try {

            // data orderitems
            $orderItems = json_decode($request->input('order_items'), true);
            // cek stok produk
            foreach ($orderItems as $item) {
                $product = Products::find($item['product_id']);
                if (!$product || $product->stock < $item['quantity']) {
                    return redirect()->back()->with('error', 'Stok produk tidak cukup: ' . $item['name']);
                }
            }

            // upload bukti pembayaran
            $FileServices = new FileUploadservice();
            $payment_proof = $FileServices->upload($request, 'payment_proof', 'payments');

            // get alamat
            $address = UserAdresses::find($request->input('address'))->address;

            DB::beginTransaction();

            // Buat order baru
            $order = Orders::create([
                'order_number' => '#ORD-' . substr(str_replace('.', '', microtime(true)), -8),
                'user_id' => Auth::id(),
                'customer_name' => $request->input('sender_name'),
                'customer_email' => Auth::user()->email,
                'customer_phone' => Auth::user()->phone,
                'shipping_address' => $address,
                'total_amount' => $request->input('total_amount'),
            ]);

            // Buat order items

            foreach ($orderItems as $item) {
                OrderItems::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }




            // Buat payments
            $payment = Payments::create([
                'order_id' => $order->id,
                'amount' => $request->input('total_amount'),
                'payment_proof' => $payment_proof,
                'transfer_date' => now(),
                'sender_name' => $request->input('sender_name'),
            ]);

            // hapus item di cart
            $cartItemIds = session('cartItemIds', []);
            if (!empty($cartItemIds)) {
                DB::table('carts')->whereIn('id', $cartItemIds)->delete();
            }

            DB::commit();

            // hapus session
            session()->forget(['address', 'orderItems', 'cartItemIds']);

            return redirect()->route('home')->with('success', 'Checkout berhasil diproses!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }


    }
}
