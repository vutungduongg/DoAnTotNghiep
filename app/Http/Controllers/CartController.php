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
        $items = $this->hydrateStockForCartItems(Cart::items());
        $totals = Cart::totals($items);

        $canCheckout = true;
        foreach ($items as $item) {
            if (!empty($item['stock_error'])) {
                $canCheckout = false;
                break;
            }
        }

        return view('store.cart.index', [
            'items' => $items,
            'totals' => $totals,
            'canCheckout' => $canCheckout,
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

        $qtyToAdd = (int) ($validated['quantity'] ?? 1);
        $qtyToAdd = max(1, min(99, $qtyToAdd));

        if ($variant !== null) {
            $stock = (int) $variant->stock;
            if ($stock <= 0) {
                return back()
                    ->withErrors(['variant_id' => 'Size này đã hết hàng.'])
                    ->withInput();
            }

            $key = Cart::key($product->id, $variant->id);
            $existingQty = (int) (Cart::items()[$key]['quantity'] ?? 0);
            $newTotal = $existingQty + $qtyToAdd;

            if ($newTotal > $stock) {
                $allowedToAdd = max(0, $stock - $existingQty);
                if ($allowedToAdd <= 0) {
                    return back()
                        ->withErrors(['quantity' => 'Số lượng trong giỏ đã đạt tối đa theo tồn kho (còn '.$stock.').'])
                        ->withInput();
                }

                Cart::add($product, $variant, $allowedToAdd);

                return back()->with('status', 'Chỉ còn '.$stock.' sản phẩm cho size này. Đã thêm '.$allowedToAdd.' vào giỏ hàng.');
            }
        }

        Cart::add($product, $variant, $qtyToAdd);

        return back()->with('status', 'Đã thêm vào giỏ hàng.');
    }

    public function update(Request $request, string $key)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        $items = Cart::items();
        $item = $items[$key] ?? null;
        if (!$item) {
            return back();
        }

        $requestedQty = (int) $validated['quantity'];

        $variantId = $item['variant_id'] ?? null;
        if (!empty($variantId)) {
            $variant = ProductVariant::query()->whereKey($variantId)->first();
            $stock = (int) ($variant?->stock ?? 0);

            if ($stock <= 0) {
                Cart::update($key, 0);

                return back()->with('status', 'Sản phẩm/size này đã hết hàng và đã được xóa khỏi giỏ.');
            }

            if ($requestedQty > $stock) {
                Cart::update($key, $stock);

                return back()->with('status', 'Chỉ còn '.$stock.' sản phẩm cho size này. Đã cập nhật số lượng về '.$stock.'.');
            }
        }

        Cart::update($key, $requestedQty);

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

    /**
     * @param array<string, array> $items
     * @return array<string, array>
     */
    private function hydrateStockForCartItems(array $items): array
    {
        $variantIds = [];
        foreach ($items as $item) {
            if (!empty($item['variant_id'])) {
                $variantIds[] = (int) $item['variant_id'];
            }
        }
        $variantIds = array_values(array_unique(array_filter($variantIds)));

        $stockMap = [];
        if ($variantIds !== []) {
            $stockMap = ProductVariant::query()
                ->whereIn('id', $variantIds)
                ->pluck('stock', 'id')
                ->all();
        }

        foreach ($items as $k => $item) {
            if (empty($item['variant_id'])) {
                $items[$k]['stock_error'] = null;
                continue;
            }

            $stock = (int) ($stockMap[(int) $item['variant_id']] ?? 0);
            $qty = (int) ($item['quantity'] ?? 0);

            $items[$k]['stock'] = $stock;
            $items[$k]['is_out_of_stock'] = $stock <= 0;
            $items[$k]['is_low_stock'] = $stock > 0 && $stock <= ProductVariant::LOW_STOCK_THRESHOLD;

            if ($stock <= 0) {
                $items[$k]['stock_error'] = 'Hết hàng';
            } elseif ($qty > $stock) {
                $items[$k]['stock_error'] = 'Vượt tồn kho (còn '.$stock.')';
            } else {
                $items[$k]['stock_error'] = null;
            }
        }

        return $items;
    }
}
