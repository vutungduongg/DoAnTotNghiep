<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Support\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::items();
        $totals = Cart::totals($items);

        return view('store.cart.index', [
            'items' => $items,
            'totals' => $totals,
        ]);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer'],
            'variant_id' => ['nullable', 'integer'],
            'size' => ['nullable', 'string', 'max:20'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $product = Product::query()
            ->whereKey($validated['product_id'])
            ->where('is_active', true)
            ->firstOrFail();

        $variant = null;
        if (!empty($validated['variant_id'])) {
            $variant = ProductVariant::query()
                ->where('product_id', $product->id)
                ->whereKey($validated['variant_id'])
                ->firstOrFail();
        } elseif (!empty($validated['size'])) {
            $variant = ProductVariant::query()
                ->where('product_id', $product->id)
                ->where('size', $validated['size'])
                ->first();
        }

        if ($variant === null && $product->variants()->exists()) {
            return back()
                ->withErrors(['variant_id' => 'Vui lòng chọn size.'])
                ->withInput();
        }

        Cart::add($product, $variant, (int) ($validated['quantity'] ?? 1));

        return back()->with('status', 'Đã thêm vào giỏ hàng.');
    }

    public function update(Request $request, string $key)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        Cart::update($key, (int) $validated['quantity']);

        return back()->with('status', 'Đã cập nhật giỏ hàng.');
    }

    public function remove(string $key)
    {
        Cart::remove($key);

        return back()->with('status', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function clear()
    {
        Cart::clear();

        return back()->with('status', 'Đã xóa toàn bộ giỏ hàng.');
    }
}
