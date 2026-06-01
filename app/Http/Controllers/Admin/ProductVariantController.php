<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductVariantController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validateWithBag('variant', [
            'size' => ['required', 'string', 'max:50', Rule::unique('product_variants', 'size')->where(fn ($q) => $q->where('product_id', $product->id))],
            'sku' => ['nullable', 'string', 'max:255', 'unique:product_variants,sku'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0', 'max:1000000'],
        ]);

        $product->variants()->create([
            'size' => $validated['size'],
            'sku' => $validated['sku'] ?? null,
            'price' => $validated['price'] ?? null,
            'stock' => (int) $validated['stock'],
        ]);

        return back()->with('status', 'Đã thêm biến thể.');
    }

    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        abort_unless((int) $variant->product_id === (int) $product->id, 404);

        $validated = $request->validateWithBag('variant', [
            'size' => ['required', 'string', 'max:50', Rule::unique('product_variants', 'size')->where(fn ($q) => $q->where('product_id', $product->id))->ignore($variant->id)],
            'sku' => ['nullable', 'string', 'max:255', Rule::unique('product_variants', 'sku')->ignore($variant->id)],
            'price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0', 'max:1000000'],
        ]);

        $variant->update([
            'size' => $validated['size'],
            'sku' => $validated['sku'] ?? null,
            'price' => $validated['price'] ?? null,
            'stock' => (int) $validated['stock'],
        ]);

        return back()->with('status', 'Đã cập nhật biến thể.');
    }

    public function destroy(Product $product, ProductVariant $variant)
    {
        abort_unless((int) $variant->product_id === (int) $product->id, 404);

        $variant->delete();

        return back()->with('status', 'Đã xóa biến thể.');
    }
}
