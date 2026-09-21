<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalOrders' => Order::count(),
            'totalRevenue' => Order::sum('total_amount'),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'customers' => User::where('role', 'customer')->count(),
            'recentOrders' => Order::with('user')->latest()->take(5)->get(),
        ]);
    }
}
