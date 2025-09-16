<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
})->name('home');

// Auth Routes
require __DIR__ . '/auth.php';


// Authentication Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard route dengan redirect berdasarkan role
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes (admin dan super_admin)
Route::middleware(['auth', 'verified', 'role:admin,super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', function () {
            return redirect()->route('dashboard');
        });

        // Product management, orders, payments, dll
        // Route::resource('products', ProductController::class);
        // Route::resource('orders', OrderController::class);
        // Route::resource('payments', PaymentController::class);
    });

// Super Admin routes (hanya super_admin)
Route::middleware(['auth', 'verified', 'role:super_admin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        // User Management
        // Route::resource('users', UserController::class);
        // Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
        //      ->name('users.toggle-status');
    
        // Payment Account Management
        // Route::resource('payment-accounts', PaymentAccountController::class);
    });

// Customer routes
Route::middleware(['auth', 'verified', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        // Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders');
        // Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
    });

// PAGES
Route::get('/product', function () {
    return view('pages.product');
})->name('product');

Route::get('/product-detail', function () {
    return view('pages.product-detail');
})->name('product.detail');

Route::get('/about-us', function () {
    return view('pages.about-us');
})->name('about-us');

Route::get('/cart', function () {
    return view('pages.cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('pages.checkout');
})->name('checkout');

Route::get('/checkout-process', function () {
    return view('pages.checkout');
})->name('checkout.process');


Route::get('/address', function () {
    return view('pages.address');
})->name('address');
Route::post('/address-store', function () {
    return view('pages.address');
})->name('addresses.store');



Route::group(['prefix' => 'admin'], function () {
    Route::get('/', function () {
        return view('pages.admin.dashboard');
    })->name('admin.dashboard');


    // Kategori
    Route::group(['prefix' => 'kategori'], function () {
        Route::get('/', function () {
            return view('pages.admin.category');
        })->name('admin.categories');

        Route::get('/create', function () {
            return view('pages.admin.category-create');
        })->name('admin.categories.create');

        Route::post('/', function () {
            // Logic to store category
        })->name('admin.categories.store');

        Route::get('/{id}/edit', function ($id) {
            return view('pages.admin.category-edit', ['id' => $id]);
        })->name('admin.categories.edit');

        Route::put('/{id}', function ($id) {
            // Logic to update category
        })->name('admin.categories.update');

        Route::delete('/{id}', function ($id) {
            // Logic to delete category
        })->name('admin.categories.destroy');
    });

    // Produk
    Route::group(['prefix' => 'produk'], function () {
        Route::get('/', function () {
            return view('pages.admin.product');
        })->name('admin.product');

        Route::get('/create', function () {
            return view('pages.admin.product-create');
        })->name('admin.product.create');

        Route::post('/', function () {
            // Logic to store product
        })->name('admin.product.store');

        Route::get('/{id}/edit', function ($id) {
            return view('pages.admin.product-edit', ['id' => $id]);
        })->name('admin.product.edit');

        Route::put('/{id}', function ($id) {
            // Logic to update product
        })->name('admin.product.update');

        Route::delete('/{id}', function ($id) {
            // Logic to delete product
        })->name('admin.product.destroy');
    });



    Route::get('/pesanan', function () {
        return view('pages.admin.order');
    })->name('admin.orders');

    Route::get('/pembayaran', function () {
        return view('pages.admin.payment');
    })->name('admin.payments');

    Route::get('/pengiriman', function () {
        return view('pages.admin.shipping');
    })->name('admin.shipping');

    Route::get('/pengembalian', function () {
        return view('pages.admin.return');
    })->name('admin.returns');

});

