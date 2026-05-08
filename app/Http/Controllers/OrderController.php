<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $ordersQuery = Order::query()
            ->where('user_id', Auth::id())
            ->latest('id');

        if (is_string($status) && in_array($status, Order::STATUSES, true)) {
            $ordersQuery->where('status', $status);
        }

        $orders = $ordersQuery
            ->paginate(10)
            ->withQueryString();

        $counts = Order::query()
            ->where('user_id', Auth::id())
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        return view('store.orders.index', [
            'orders' => $orders,
            'status' => $status,
            'statuses' => Order::STATUSES,
            'counts' => $counts,
        ]);
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $order->load(['items.product']);

        return view('store.orders.show', [
            'order' => $order,
            'isGuest' => false,
        ]);
    }

    public function trackForm()
    {
        return view('store.orders.track');
    }

    public function track(Request $request)
    {
        $validated = $request->validate([
            'order_number' => ['required', 'string', 'max:50'],
            'customer_email' => ['required', 'email', 'max:255'],
        ]);

        $order = Order::query()
            ->where('order_number', $validated['order_number'])
            ->where('customer_email', $validated['customer_email'])
            ->first();

        if (!$order) {
            return back()
                ->withErrors(['order_number' => 'Không tìm thấy đơn hàng (kiểm tra lại mã đơn và email).'])
                ->withInput();
        }

        $order->load(['items.product']);

        return view('store.orders.show', [
            'order' => $order,
            'isGuest' => true,
        ]);
    }

    public function thankYou(string $order_number)
    {
        $order = Order::query()->where('order_number', $order_number)->firstOrFail();

        $allowed = false;
        if (Auth::check() && $order->user_id === Auth::id()) {
            $allowed = true;
        }

        if (!$allowed && session('order_email') === $order->customer_email) {
            $allowed = true;
        }

        abort_unless($allowed, 403);

        $order->load(['items.product']);

        return view('store.orders.thankyou', [
            'order' => $order,
        ]);
    }
}
