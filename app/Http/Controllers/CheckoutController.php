<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Support\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function create()
    {
        $items = Cart::items();
        if ($items === []) {
            return redirect()->route('cart.index')->with('status', 'Giỏ hàng đang trống.');
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
}
