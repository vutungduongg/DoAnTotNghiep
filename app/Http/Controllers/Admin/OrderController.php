<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $status = $request->query('status');

        $ordersQuery = Order::query()->orderByDesc('id');

        if ($q !== '') {
            $ordersQuery->where(function ($qb) use ($q) {
                $qb->where('order_number', 'like', '%'.$q.'%')
                    ->orWhere('customer_email', 'like', '%'.$q.'%')
                    ->orWhere('customer_phone', 'like', '%'.$q.'%')
                    ->orWhere('customer_name', 'like', '%'.$q.'%');
            });
        }

        if (is_string($status) && $status !== '' && in_array($status, Order::STATUSES, true)) {
            $ordersQuery->where('status', $status);
        }

        $orders = $ordersQuery->paginate(15)->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'q' => $q,
            'status' => $status,
            'statuses' => Order::STATUSES,
        ]);
    }

    public function edit(Order $order)
    {
        $order->load('items');

        return view('admin.orders.edit', [
            'order' => $order,
            'statuses' => Order::STATUSES,
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'string'],
        ]);

        if (!in_array($validated['status'], Order::STATUSES, true)) {
            return back()->withErrors(['status' => 'Trạng thái không hợp lệ.']);
        }

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.orders.index')->with('status', 'Đã cập nhật trạng thái đơn hàng.');
    }
}
