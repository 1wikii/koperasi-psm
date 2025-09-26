<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\Products;


class ProductController extends Controller
{
    public function index()
    {
        // Logic to fetch and return products
        $products = Products::where('is_active', true)->paginate(10);
        return view('pages.product.index', compact('products'));
    }

    public function indexCategory($categorySlug)
    {
        // Logic to fetch and return products by category
        $products = Products::join('categories', 'products.category_id', '=', 'categories.id')
            ->where('categories.slug', $categorySlug)
            ->where('products.is_active', true)
            ->select('products.*')
            ->with('category:id,name,slug')
            ->get();
        return view('pages.product.index', compact('products'));
    }

    public function show($slug)
    {
        // Logic to fetch and return a single product by its ID
        $product = Products::with([
            'category' =>
                function ($query) {
                    $query->select('id', 'name', 'slug');
                }
        ])->where('is_active', true)->where('slug', $slug)->firstOrFail();
        return view('pages.product.show', compact('product'));
    }
}
