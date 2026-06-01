<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $variants = ProductVariant::query()
            ->with(['product' => fn ($q) => $q->with('category')])
            ->orderBy('stock')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.inventory.index', [
            'variants' => $variants,
            'lowThreshold' => ProductVariant::LOW_STOCK_THRESHOLD,
        ]);
    }

    public function update(Request $request, ProductVariant $variant)
    {
        $validated = $request->validateWithBag('inventory', [
            'stock' => ['required', 'integer', 'min:0', 'max:1000000'],
        ]);

        $variant->update([
            'stock' => (int) $validated['stock'],
        ]);

        return back()->with('status', 'Đã cập nhật tồn kho.');
    }
}
