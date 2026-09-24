<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('category', 'images')->where('status', 'active');
        $selectedCategory = $this->applyCategoryFilter($query, $request);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return view('customer.storefront', [
            'categories' => Category::latest()->get(),
            'products' => $query->latest()->paginate(4),
            'selectedCategory' => $selectedCategory,
            'cartCount' => Cart::where('user_id', auth()->id())->sum('quantity'),
        ]);
    }

    public function shop(Request $request): View
    {
        $query = Product::with('category', 'images')->where('status', 'active');
        $selectedCategory = $this->applyCategoryFilter($query, $request);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return view('customer.storefront', [
            'categories' => Category::latest()->get(),
            'products' => $query->latest()->paginate(4),
            'selectedCategory' => $selectedCategory,
            'cartCount' => Cart::where('user_id', auth()->id())->sum('quantity'),
        ]);
    }

    public function showProduct(string $slug): View
    {
        $product = Product::with('category', 'images')->where('slug', $slug)->where('status', 'active')->firstOrFail();

        return view('customer.product', [
            'product' => $product,
        ]);
    }

    private function applyCategoryFilter($query, Request $request): ?string
    {
        $categorySlug = $request->query('category');

        if (! $categorySlug) {
            return null;
        }

        $category = Category::where('slug', $categorySlug)->firstOrFail();
        $query->where('category_id', $category->id);

        return $category->slug;
    }
}
