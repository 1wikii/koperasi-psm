<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Orders;
use App\Models\PaymentAccounts;
use App\Models\Payments;
use App\Models\Products;
use App\Models\Returns;
use App\Services\FileUploadservice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Total semua pesanan
        $totalOrders = Orders::whereNot('status', 'rejected')->count();
        $ordersThisWeek = Orders::whereNot('status', 'rejected')->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();


        // Total pendapatan
        $totalRevenue = Orders::whereNot('status', 'rejected')->whereNot('status', 'waiting')->sum('total_amount');
        $revenueThisWeek = Orders::whereNot('status', 'rejected')->whereNot('status', 'waiting')
            ->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->sum('total_amount');

        // Total pengembalian
        $totalReturns = Returns::count();

        // Total produk terkirim
        $totalCompletedOrders = Orders::where('status', 'completed')->count();
        $completedOrdersThisWeek = Orders::where('status', 'completed')
            ->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count();



        // chart orders data
        $orders = Orders::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupBy('date')
            ->pluck('total', 'date'); // hasilnya collection: ['2025-09-22' => 2, ...]

        $dailyOrders = [];
        $startOfWeek = now()->startOfWeek();
        for ($i = 0; $i < 7; $i++) {
            $day = $startOfWeek->copy()->addDays($i)->toDateString();
            $dailyOrders[] = $orders[$day] ?? 0;
        }

        // latest 3 orders
        $latestOrders = Orders::latest()->take(3)->get();

        return view('pages.admin.dashboard', [
            'totalOrders' => $totalOrders,
            'ordersThisWeek' => $ordersThisWeek,
            'totalRevenue' => $totalRevenue,
            'revenueThisWeek' => $revenueThisWeek,
            'totalReturns' => $totalReturns,
            'totalCompletedOrders' => $totalCompletedOrders,
            'completedOrdersThisWeek' => $completedOrdersThisWeek,
            'dailyOrders' => $dailyOrders,
            'latestOrders' => $latestOrders,
        ]);
    }



    /**
     * Summary of category
     * 
     */
    public function category()
    {
        $categories = Categories::with('products')->get()->map(function ($category) {
            return [
                'id' => $category->id,
                'image' => $category->image,
                'name' => $category->name,
                'product_count' => $category->products->count(),
                'status' => $category->is_active,
            ];
        });
        return view('pages.admin.category', compact('categories'));
    }

    public function categoryStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
            'icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori maksimal 50 karakter.',
            'name.unique' => 'Nama kategori sudah ada.',
            'icon.image' => 'File harus berupa gambar.',
            'icon.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'icon.max' => 'Ukuran gambar maksimal 2MB.',
        ]);
        try {
            DB::beginTransaction();

            $fileUploadService = new FileUploadservice();
            $image_path = $fileUploadService->upload($request, 'icon', 'categories');

            Categories::create([
                'slug' => \Str::slug($validated['name']),
                'name' => $validated['name'],
                'image' => $image_path,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    public function categoryUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name,' . $id,
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori maksimal 50 karakter.',
            'name.unique' => 'Nama kategori sudah ada.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);
        try {
            DB::beginTransaction();

            $fileUploadService = new FileUploadservice();
            $image_path = $fileUploadService->upload($request, 'image', 'categories');

            Categories::where('id', $id)->update([
                'slug' => \Str::slug($validated['name']),
                'name' => $validated['name'],
                'image' => $image_path,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }

    public function categoryDelete($id)
    {
        try {
            DB::beginTransaction();

            Categories::where('id', $id)->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }

    /**
     * Summary of product
     * 
     */

    public function product()
    {
        $categories = Categories::where('is_active', 1)->get();
        $products = Products::with('category')->where('is_active', 1)->get();
        return view('pages.admin.product', compact('categories', 'products'));
    }

    public function productStore(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:products,name',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'images' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk maksimal 100 karakter.',
            'name.unique' => 'Nama produk sudah ada.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga minimal 0.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.integer' => 'Stok harus berupa bilangan bulat.',
            'stock.min' => 'Stok minimal 0.',
            'images.required' => 'Gambar produk wajib diunggah.',
            'images.image' => 'File harus berupa gambar.',
            'images.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'images.max' => 'Ukuran gambar maksimal 2MB per gambar.',
        ]);

        try {
            DB::beginTransaction();

            $fileUploadService = new FileUploadservice();
            $image_path = $fileUploadService->upload($request, 'images', 'products');

            Products::create([
                'slug' => \Str::slug($validated['name']),
                'name' => $validated['name'],
                'category_id' => $validated['category_id'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'description' => $validated['description'] ?? null,
                'images' => $image_path,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage());
        }

    }

    public function productUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:products,name,' . $id,
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'images' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk maksimal 100 karakter.',
            'name.unique' => 'Nama produk sudah ada.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga minimal 0.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.integer' => 'Stok harus berupa bilangan bulat.',
            'stock.min' => 'Stok minimal 0.',
            'images.image' => 'File harus berupa gambar.',
            'images.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'images.max' => 'Ukuran gambar maksimal 2MB per gambar.',
        ]);

        try {
            DB::beginTransaction();

            $fileUploadService = new FileUploadservice();
            $image_path = $fileUploadService->upload($request, 'images', 'products');

            $updateData = [
                'slug' => \Str::slug($validated['name']),
                'name' => $validated['name'],
                'category_id' => $validated['category_id'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'description' => $validated['description'] ?? null,
            ];

            if ($image_path) {
                $updateData['images'] = $image_path;
            }

            Products::where('id', $id)->update($updateData);

            DB::commit();

            return redirect()->back()->with('success', 'Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    public function productDelete($id)
    {
        try {
            DB::beginTransaction();

            Products::where('id', $id)->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }


    /**
     * Summary of order
     * 
     */
    public function order()
    {
        $type = DB::select("SHOW COLUMNS FROM orders WHERE Field = 'status'")[0]->Type;
        preg_match("/^enum\('(.*)'\)$/", $type, $matches);
        $enumValues = explode("','", $matches[1]);

        $orders = Orders::with('user', 'orderItems.products', 'payment')->get()->map(function ($order) {
            $order->date = Carbon::parse($order->created_at)->format('d-m-Y');
            return $order;
        });

        $paymentAccount = PaymentAccounts::where('is_active', 1)->firstOrFail();

        return view('pages.admin.order', ['status' => $enumValues, 'orders' => $orders, 'paymentAccount' => $paymentAccount]);
    }

    public function approvePayment(Request $request, $id)
    {
        $validated = $request->validate([
            'order_items' => 'required',
        ], [
            'order_items.required' => 'Data item cart wajib diisi.',
        ]);

        try {
            DB::beginTransaction();

            // Kurangi stok produk berdasarkan order_items
            foreach ($validated['order_items'] as $item) {
                $product = Products::find($item['product_id']);
                if ($product) {
                    $newStock = $product->stock - $item['quantity'];
                    $product->stock = $newStock >= 0 ? $newStock : 0;
                    $product->save();
                }
            }

            // Ubah status order menjadi 'sending'
            $order = Orders::findOrFail($id);
            $order->status = 'sending';
            $order->save();

            DB::commit();

            return redirect()->back()->with('success', 'Pembayaran berhasil disetujui.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();

            dd($e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyetujui pembayaran: ' . $e->getMessage());
        }
    }


    public function rejectPayment($id)
    {
        try {
            DB::beginTransaction();

            $order = Orders::findOrFail($id);
            $order->status = 'rejected';
            $order->save();

            DB::commit();

            return redirect()->back()->with('success', 'Pembayaran berhasil ditolak.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menolak pembayaran: ' . $e->getMessage());
        }
    }

    public function payment()
    {
        return view('pages.admin.payment');
    }


    public function return()
    {
        return view('pages.admin.return');
    }

    public function shipping()
    {
        return view('pages.admin.shipping');
    }
}
