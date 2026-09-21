<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        $products = Product::with('category', 'images')
            ->where('status', 'active')
            ->where('stock', '>', 0)
            ->latest()
            ->get();

        return view('customer.cart', [
            'cartItems' => $cartItems,
            'products' => $products,
            'total' => $cartItems->sum(fn ($item) => $item->quantity * $item->product->price),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->status !== 'active' || $product->stock < 1) {
            return back()->withErrors(['product_id' => 'This product is currently unavailable.']);
        }

        $cartItem = Cart::firstOrNew([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        $requestedQuantity = ($cartItem->exists ? $cartItem->quantity : 0) + ($validated['quantity'] ?? 1);
        $cartItem->quantity = min($requestedQuantity, $product->stock);
        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request, Cart $cart): RedirectResponse
    {
        abort_unless($cart->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if (! $cart->product || $cart->product->status !== 'active' || $cart->product->stock < 1) {
            return back()->withErrors(['quantity' => 'This product is currently unavailable.']);
        }

        $cart->update([
            'quantity' => min($validated['quantity'], $cart->product->stock),
        ]);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function destroy(Cart $cart): RedirectResponse
    {
        abort_unless($cart->user_id === auth()->id(), 403);

        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }
}
