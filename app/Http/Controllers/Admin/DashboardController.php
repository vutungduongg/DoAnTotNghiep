<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $ordersCount = Order::query()->count();
        $productsCount = Product::query()->count();
        $customersCount = User::query()->where('is_admin', false)->count();

        $revenueTotal = (float) Order::query()
            ->where('status', '!=', Order::STATUS_CANCELLED)
            ->sum('total');

        $recentOrders = Order::query()
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        $top = OrderItem::query()
            ->selectRaw('product_name, SUM(quantity) as qty')
            ->groupBy('product_name')
            ->orderByDesc('qty')
            ->limit(3)
            ->get();

        $maxQty = (int) ($top->max('qty') ?? 0);
        $maxQty = $maxQty > 0 ? $maxQty : 1;

        $topProducts = $top->map(function ($row) use ($maxQty) {
            $qty = (int) $row->qty;

            return [
                'name' => (string) $row->product_name,
                'qty' => $qty,
                'percent' => (int) round(($qty / $maxQty) * 100),
            ];
        });

        return view('admin.dashboard', [
            'ordersCount' => $ordersCount,
            'productsCount' => $productsCount,
            'customersCount' => $customersCount,
            'revenueTotal' => $revenueTotal,
            'recentOrders' => $recentOrders,
            'topProducts' => $topProducts,
        ]);
    }
}
