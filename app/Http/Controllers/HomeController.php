<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $featuredProducts = Product::query()
            ->where('is_active', true)
            ->with('category')
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        return view('store.home', [
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
        ]);
    }
}
