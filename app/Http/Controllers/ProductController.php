<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $productsQuery = Product::query()
            ->where('is_active', true)
            ->with('category');

        $q = trim((string) $request->query('q', ''));
        if ($q !== '') {
            $productsQuery->where('name', 'like', '%'.$q.'%');
        }

        $category = $request->query('category');
        if (is_string($category) && $category !== '') {
            if (ctype_digit($category)) {
                $productsQuery->where('category_id', (int) $category);
            } else {
                $productsQuery->whereHas('category', fn ($q) => $q->where('slug', $category));
            }
        }

        $minPrice = $request->query('min_price');
        if ($minPrice !== null && is_numeric($minPrice)) {
            $productsQuery->where('base_price', '>=', (float) $minPrice);
        }

        $maxPrice = $request->query('max_price');
        if ($maxPrice !== null && is_numeric($maxPrice)) {
            $productsQuery->where('base_price', '<=', (float) $maxPrice);
        }

        $products = $productsQuery
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('store.products.index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => [
                'q' => $q,
                'category' => $category,
                'min_price' => $minPrice,
                'max_price' => $maxPrice,
            ],
        ]);
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $product->load(['category', 'variants' => fn ($q) => $q->orderBy('size')]);

        return view('store.products.show', [
            'product' => $product,
        ]);
    }
}
