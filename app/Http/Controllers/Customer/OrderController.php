<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('items.product')->where('user_id', auth()->id())->latest()->get();

        return view('customer.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show(Order $order): View
    {
        abort_unless($order->user_id === auth()->id(), 403);

        return view('customer.orders.show', [
            'order' => $order->load('items.product'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'shipping_address' => ['required', 'string', 'min:10'],
            'notes' => ['nullable', 'string'],
        ]);

        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Your cart is empty.']);
        }

        $totalAmount = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'BK-'.now()->format('YmdHis').'-'.auth()->id(),
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'shipping_address' => $validated['shipping_address'],
            'notes' => $validated['notes'] ?? null,
            'payment_status' => 'pending',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->product->price,
                'subtotal' => $item->product->price * $item->quantity,
            ]);

            $product = Product::find($item->product_id);

            if ($product) {
                $product->stock = max(0, $product->stock - $item->quantity);
                $product->status = $product->stock === 0 ? 'out_of_stock' : 'active';
                $product->save();
            }
        }

        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully.');
    }
}
