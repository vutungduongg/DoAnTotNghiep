<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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

        $type = $request->query('type');
        if (is_string($type) && $type !== '') {
            if ($type === 'ao_dau') {
                $productsQuery->whereHas('category', fn ($q) => $q->where('slug', 'ao-the-thao'));
            }
            if ($type === 'giay') {
                $productsQuery->whereHas('category', fn ($q) => $q->where('slug', 'giay-bong-da'));
            }
        }

        $categoryInput = $request->query('category');
        $categoryValues = Arr::wrap($categoryInput);
        $categoryValues = array_values(array_filter(array_map(fn ($v) => is_string($v) ? trim($v) : $v, $categoryValues), fn ($v) => $v !== null && $v !== ''));

        $categoryIds = [];
        $categorySlugs = [];
        foreach ($categoryValues as $value) {
            if (!is_string($value)) {
                continue;
            }

            if (ctype_digit($value)) {
                $categoryIds[] = (int) $value;
            } else {
                $categorySlugs[] = $value;
            }
        }

        $resolvedCategoryIds = [];
        if (!empty($categorySlugs)) {
            $resolvedCategoryIds = Category::query()
                ->whereIn('slug', array_unique($categorySlugs))
                ->pluck('id')
                ->all();
        }

        $allCategoryIds = array_values(array_unique(array_merge($categoryIds, $resolvedCategoryIds)));
        if (!empty($allCategoryIds)) {
            $productsQuery->whereIn('category_id', $allCategoryIds);
        }

        $minPrice = $request->query('min_price');
        if ($minPrice !== null && is_numeric($minPrice)) {
            $productsQuery->where('base_price', '>=', (float) $minPrice);
        }

        $maxPrice = $request->query('max_price');
        if ($maxPrice !== null && is_numeric($maxPrice)) {
            $productsQuery->where('base_price', '<=', (float) $maxPrice);
        }

        $studInput = $request->query('stud');
        $studValues = Arr::wrap($studInput);
        $studValues = array_values(array_unique(array_filter(array_map(fn ($v) => is_string($v) ? strtoupper(trim($v)) : $v, $studValues), fn ($v) => is_string($v) && in_array($v, ['AG', 'FG', 'TF'], true))));

        if (!empty($studValues)) {
            $productsQuery->where(function ($q) use ($studValues) {
                foreach ($studValues as $stud) {
                    $q->orWhere('name', 'like', '%'.$stud.'%');
                }
            });
        }

        $productsQueryForFacets = clone $productsQuery;

        $sizeInput = $request->query('size');
        $sizeValues = Arr::wrap($sizeInput);
        $sizeValues = array_values(array_unique(array_filter(array_map(fn ($v) => is_string($v) ? trim($v) : $v, $sizeValues), fn ($v) => is_string($v) && $v !== '')));

        if (!empty($sizeValues)) {
            $productsQuery->whereHas('variants', fn ($q) => $q->whereIn('size', $sizeValues));
        }

        $sort = $request->query('sort');
        if (!is_string($sort)) {
            $sort = '';
        }
        $sort = trim($sort);

        match ($sort) {
            'price_asc' => $productsQuery->orderBy('base_price', 'asc')->orderBy('id', 'desc'),
            'price_desc' => $productsQuery->orderBy('base_price', 'desc')->orderBy('id', 'desc'),
            'newest' => $productsQuery->orderByDesc('created_at')->orderByDesc('id'),
            default => $productsQuery->orderByDesc('id'),
        };

        $products = $productsQuery
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $availableSizes = ProductVariant::query()
            ->whereIn('product_id', $productsQueryForFacets->select('products.id'))
            ->select('size')
            ->distinct()
            ->orderBy('size')
            ->pluck('size')
            ->all();

        return view('store.products.index', [
            'products' => $products,
            'categories' => $categories,
            'availableSizes' => $availableSizes,
            'filters' => [
                'q' => $q,
                'type' => $type,
                'category' => array_values(array_unique($categorySlugs)),
                'min_price' => $minPrice,
                'max_price' => $maxPrice,
                'stud' => $studValues,
                'size' => $sizeValues,
                'sort' => $sort,
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
