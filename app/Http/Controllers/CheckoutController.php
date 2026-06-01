<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Support\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function create()
    {
        $items = Cart::items();
        if ($items === []) {
            return redirect()->route('cart.index')->with('status', 'Giỏ hàng đang trống.');
        }

        $issues = $this->cartStockIssues($items);
        if ($issues !== []) {
            return redirect()
                ->route('cart.index')
                ->with('status', 'Một số sản phẩm đã hết hàng hoặc vượt tồn kho. Vui lòng cập nhật giỏ hàng.');
        }

        $totals = Cart::totals($items);

        return view('store.checkout.index', [
            'items' => $items,
            'totals' => $totals,
            'user' => Auth::user(),
        ]);
    }

    public function store(Request $request)
    {
        $items = Cart::items();
        if ($items === []) {
            return redirect()->route('cart.index')->with('status', 'Giỏ hàng đang trống.');
        }

        $issues = $this->cartStockIssues($items);
        if ($issues !== []) {
            throw ValidationException::withMessages([
                'stock' => ['Một số sản phẩm đã hết hàng hoặc vượt tồn kho. Vui lòng quay lại giỏ hàng để cập nhật.'],
            ]);
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:2000'],
        ]);

        $totals = Cart::totals($items);
        $subtotal = $totals['subtotal'];
        $shippingFee = '0.00';
        $total = $subtotal;

        $order = DB::transaction(function () use ($items, $validated, $subtotal, $shippingFee, $total) {
            $productIds = array_values(array_unique(array_map(fn ($it) => (int) $it['product_id'], $items)));
            $inactiveCount = Product::query()
                ->whereIn('id', $productIds)
                ->where('is_active', false)
                ->count();
            if ($inactiveCount > 0) {
                throw ValidationException::withMessages([
                    'stock' => ['Một số sản phẩm trong giỏ đã ngừng bán. Vui lòng quay lại giỏ hàng để cập nhật.'],
                ]);
            }

            $variantNeeds = [];
            foreach ($items as $item) {
                if (!empty($item['variant_id'])) {
                    $variantNeeds[(int) $item['variant_id']] = (int) $item['quantity'];
                }
            }

            if ($variantNeeds !== []) {
                $variants = ProductVariant::query()
                    ->whereIn('id', array_keys($variantNeeds))
                    ->lockForUpdate()
                    ->get();

                if ($variants->count() !== count($variantNeeds)) {
                    throw ValidationException::withMessages([
                        'stock' => ['Một số size không còn tồn tại. Vui lòng quay lại giỏ hàng để cập nhật.'],
                    ]);
                }

                foreach ($variants as $variant) {
                    $need = (int) ($variantNeeds[(int) $variant->id] ?? 0);
                    if ((int) $variant->stock < $need) {
                        throw ValidationException::withMessages([
                            'stock' => ['Một số size đã hết hàng hoặc không đủ số lượng. Vui lòng quay lại giỏ hàng để cập nhật.'],
                        ]);
                    }
                }
            }

            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => Auth::id(),
                'status' => Order::STATUS_PENDING,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $validated['shipping_address'],
                'note' => $validated['note'] ?? null,
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'total' => $total,
            ]);

            foreach ($items as $item) {
                $qty = (int) $item['quantity'];
                $unit = (float) $item['price'];
                $lineTotal = number_format($unit * $qty, 2, '.', '');

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['variant_id'],
                    'product_name' => $item['name'],
                    'size' => $item['size'],
                    'unit_price' => number_format($unit, 2, '.', ''),
                    'quantity' => $qty,
                    'line_total' => $lineTotal,
                ]);
            }

            if ($variantNeeds !== []) {
                foreach ($variantNeeds as $variantId => $qty) {
                    ProductVariant::query()
                        ->whereKey($variantId)
                        ->decrement('stock', (int) $qty);
                }
            }

            return $order;
        });

        Cart::clear();

        return redirect()
            ->route('orders.thankyou', ['order_number' => $order->order_number])
            ->with('order_email', $order->customer_email);
    }

    private function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $rand = Str::upper(Str::random(8));

        return 'ORD-'.$date.'-'.$rand;
    }

    /**
     * @param array<string, array> $items
     * @return array<int, string>
     */
    private function cartStockIssues(array $items): array
    {
        $variantIds = [];
        foreach ($items as $item) {
            if (!empty($item['variant_id'])) {
                $variantIds[] = (int) $item['variant_id'];
            }
        }
        $variantIds = array_values(array_unique(array_filter($variantIds)));

        if ($variantIds === []) {
            return [];
        }

        $stockMap = ProductVariant::query()
            ->whereIn('id', $variantIds)
            ->pluck('stock', 'id')
            ->all();

        $issues = [];
        foreach ($items as $item) {
            if (empty($item['variant_id'])) {
                continue;
            }
            $variantId = (int) $item['variant_id'];
            $stock = (int) ($stockMap[$variantId] ?? 0);
            $qty = (int) ($item['quantity'] ?? 0);

            if ($stock <= 0) {
                $issues[] = 'Hết hàng';
                continue;
            }

            if ($qty > $stock) {
                $issues[] = 'Vượt tồn kho';
            }
        }

        return $issues;
    }
}
