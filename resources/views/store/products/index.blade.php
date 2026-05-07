<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sản phẩm - {{ config('app.name', 'VT Store') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">

    @php
        $activeCategorySlug = (array)($filters['category'] ?? []);
        $isShoes = ($filters['type'] ?? '') === 'giay' || in_array('giay-bong-da', $activeCategorySlug, true);
        $isJersey = ($filters['type'] ?? '') === 'ao_dau' || in_array('ao-the-thao', $activeCategorySlug, true);

        $pageLabel = 'Sản phẩm';
        if ($isShoes) $pageLabel = 'Giày bóng đá';
        if ($isJersey) $pageLabel = 'Áo thể thao';

        $phuKien = $categories->firstWhere('slug', 'phu-kien');

        $sortLabel = match (($filters['sort'] ?? '')) {
            'newest' => 'Mới nhất',
            'price_asc' => 'Giá tăng dần',
            'price_desc' => 'Giá giảm dần',
            default => 'Mặc định',
        };

        $minPriceValue = is_numeric($filters['min_price'] ?? null) ? (float) $filters['min_price'] : 0;
        $maxPriceValue = is_numeric($filters['max_price'] ?? null) ? (float) $filters['max_price'] : 5000000;
    @endphp

    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="h-16 flex items-center gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                    <span class="text-lg font-extrabold italic tracking-tight">VTSTORE</span>
                </a>

                <nav class="hidden md:flex items-center gap-6 text-xs font-semibold tracking-wide uppercase text-slate-700">
                    <a class="hover:text-slate-900 {{ $isShoes ? 'text-slate-900' : '' }}" href="{{ route('products.index', ['type' => 'giay']) }}">Giày bóng đá</a>
                    <a class="hover:text-slate-900 {{ $isJersey ? 'text-slate-900' : '' }}" href="{{ route('products.index', ['type' => 'ao_dau']) }}">Áo bóng đá</a>
                    <a class="hover:text-slate-900" href="{{ $phuKien ? route('products.index', ['category' => $phuKien->slug]) : route('products.index') }}">Phụ kiện</a>
                </nav>

                <form class="flex-1 flex justify-center" method="GET" action="{{ route('products.index') }}">
                    <input type="hidden" name="type" value="{{ $filters['type'] ?? '' }}" />
                    @foreach ((array)($filters['category'] ?? []) as $cat)
                        <input type="hidden" name="category[]" value="{{ $cat }}" />
                    @endforeach
                    @foreach ((array)($filters['stud'] ?? []) as $stud)
                        <input type="hidden" name="stud[]" value="{{ $stud }}" />
                    @endforeach
                    @foreach ((array)($filters['size'] ?? []) as $s)
                        <input type="hidden" name="size[]" value="{{ $s }}" />
                    @endforeach
                    <input type="hidden" name="min_price" value="{{ $filters['min_price'] ?? '' }}" />
                    <input type="hidden" name="max_price" value="{{ $filters['max_price'] ?? '' }}" />
                    <input type="hidden" name="sort" value="{{ $filters['sort'] ?? '' }}" />

                    <div class="w-full max-w-lg relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <input
                            name="q"
                            value="{{ $filters['q'] ?? '' }}"
                            placeholder="Tìm kiếm sản phẩm..."
                            class="w-full h-10 pl-9 pr-3 rounded-full border border-slate-200 bg-slate-100 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                        />
                    </div>
                </form>

                <div class="flex items-center gap-3 shrink-0 text-xs font-semibold tracking-wide uppercase">
                    @auth
                        <a href="{{ route('profile.edit') }}" class="text-slate-700 hover:text-slate-900">Tài khoản</a>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-700 hover:text-slate-900">Đăng nhập</a>
                        <span class="text-slate-300">/</span>
                        <a href="{{ route('register') }}" class="text-slate-700 hover:text-slate-900">Đăng ký</a>
                    @endauth

                    <a href="{{ route('cart.index') }}" class="ml-2 relative inline-flex items-center justify-center h-10 w-10 rounded-full hover:bg-slate-100" aria-label="Giỏ hàng">
                        <svg class="h-5 w-5 text-slate-700" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>

                        @php $cartCount = \App\Support\Cart::count(); @endphp
                        @if ($cartCount > 0)
                            <span class="absolute -top-1 -right-1 min-w-4 h-4 px-1 inline-flex items-center justify-center rounded-full bg-emerald-600 text-white text-[10px] font-bold">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-6">
        <nav class="text-xs text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-slate-900">Trang chủ</a>
            <span class="mx-1">·</span>
            <span class="text-slate-700">{{ $pageLabel }}</span>
        </nav>

        <div class="mt-4 grid grid-cols-1 lg:grid-cols-12 gap-6">
            <aside class="lg:col-span-3">
                <form id="filter-form" method="GET" action="{{ route('products.index') }}" class="bg-white border border-slate-200 rounded-xl p-5">
                    <input type="hidden" name="q" value="{{ $filters['q'] ?? '' }}" />
                    <input type="hidden" name="sort" value="{{ $filters['sort'] ?? '' }}" />
                    <input type="hidden" name="type" value="{{ $filters['type'] ?? '' }}" />
                    @foreach ((array)($filters['category'] ?? []) as $cat)
                        <input type="hidden" name="category[]" value="{{ $cat }}" />
                    @endforeach

                    <div class="space-y-5">
                        @if ($isShoes)
                            <div>
                                <p class="text-xs font-semibold tracking-wide uppercase text-slate-700">Loại đinh</p>
                                <div class="mt-3 space-y-2">
                                    @foreach (['AG' => 'Sân cỏ nhân tạo (AG)', 'FG' => 'Sân cỏ tự nhiên (FG)', 'TF' => 'Sân cỏ nhân tạo đế bằng (TF)'] as $value => $label)
                                        <label class="flex items-center gap-2 text-sm text-slate-700">
                                            <input
                                                type="checkbox"
                                                name="stud[]"
                                                value="{{ $value }}"
                                                class="rounded border-slate-300 text-slate-900 focus:ring-slate-900/10"
                                                {{ in_array($value, (array)($filters['stud'] ?? []), true) ? 'checked' : '' }}
                                            />
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div>
                            <p class="text-xs font-semibold tracking-wide uppercase text-slate-700">Khoảng giá</p>
                            <div class="mt-3">
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span>{{ number_format($minPriceValue, 0, ',', '.') }}đ</span>
                                    <span>{{ number_format($maxPriceValue, 0, ',', '.') }}đ</span>
                                </div>

                                <input
                                    id="max-price-range"
                                    type="range"
                                    min="0"
                                    max="5000000"
                                    step="50000"
                                    value="{{ is_numeric($filters['max_price'] ?? null) ? (int) $filters['max_price'] : 5000000 }}"
                                    class="mt-3 w-full accent-slate-900"
                                    aria-label="Giá tối đa"
                                />

                                <div class="mt-3 grid grid-cols-2 gap-2">
                                    <input
                                        name="min_price"
                                        value="{{ $filters['min_price'] ?? '' }}"
                                        placeholder="Từ"
                                        class="h-9 px-3 rounded border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                                    />
                                    <input
                                        id="max-price-input"
                                        name="max_price"
                                        value="{{ $filters['max_price'] ?? '' }}"
                                        placeholder="Đến"
                                        class="h-9 px-3 rounded border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                                    />
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs font-semibold tracking-wide uppercase text-slate-700">Kích cỡ</p>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @forelse ((array) $availableSizes as $size)
                                    <label>
                                        <input
                                            type="checkbox"
                                            name="size[]"
                                            value="{{ $size }}"
                                            class="peer sr-only"
                                            {{ in_array($size, (array)($filters['size'] ?? []), true) ? 'checked' : '' }}
                                        />
                                        <span class="inline-flex items-center justify-center h-8 min-w-10 px-3 rounded border border-slate-200 text-sm text-slate-700 peer-checked:border-slate-900 peer-checked:bg-slate-900 peer-checked:text-white">
                                            {{ $size }}
                                        </span>
                                    </label>
                                @empty
                                    <p class="text-sm text-slate-500">Chưa có dữ liệu kích cỡ.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="pt-1">
                            <button type="submit" class="w-full h-10 rounded bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800">
                                Áp dụng lọc
                            </button>
                            <a href="{{ route('products.index') }}" class="mt-2 block text-center text-sm text-slate-600 hover:text-slate-900">
                                Xóa bộ lọc
                            </a>
                        </div>
                    </div>
                </form>
            </aside>

            <section class="lg:col-span-9">
                <div class="flex items-center justify-between gap-4">
                    <p class="text-sm text-slate-600">
                        @if ($products->total() > 0)
                            Hiển thị {{ $products->count() }} trên {{ $products->total() }} sản phẩm
                        @else
                            Không có sản phẩm
                        @endif
                    </p>

                    <form method="GET" action="{{ route('products.index') }}" class="flex items-center gap-2">
                        <input type="hidden" name="q" value="{{ $filters['q'] ?? '' }}" />
                        <input type="hidden" name="type" value="{{ $filters['type'] ?? '' }}" />
                        @foreach ((array)($filters['category'] ?? []) as $cat)
                            <input type="hidden" name="category[]" value="{{ $cat }}" />
                        @endforeach
                        @foreach ((array)($filters['stud'] ?? []) as $stud)
                            <input type="hidden" name="stud[]" value="{{ $stud }}" />
                        @endforeach
                        @foreach ((array)($filters['size'] ?? []) as $s)
                            <input type="hidden" name="size[]" value="{{ $s }}" />
                        @endforeach
                        <input type="hidden" name="min_price" value="{{ $filters['min_price'] ?? '' }}" />
                        <input type="hidden" name="max_price" value="{{ $filters['max_price'] ?? '' }}" />

                        <span class="text-xs font-semibold tracking-wide uppercase text-slate-500">Sắp xếp</span>
                        <select
                            name="sort"
                            class="h-9 pl-3 pr-8 rounded border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                            onchange="this.form.submit()"
                        >
                            <option value="">Mặc định</option>
                            <option value="newest" @selected(($filters['sort'] ?? '') === 'newest')>Mới nhất</option>
                            <option value="price_asc" @selected(($filters['sort'] ?? '') === 'price_asc')>Giá tăng dần</option>
                            <option value="price_desc" @selected(($filters['sort'] ?? '') === 'price_desc')>Giá giảm dần</option>
                        </select>
                    </form>
                </div>

                <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                    @forelse ($products as $product)
                        <a href="{{ route('products.show', $product) }}" class="group bg-white border border-slate-200 rounded-xl overflow-hidden hover:shadow-sm transition">
                            <div class="relative aspect-square bg-slate-950">
                                @if ($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="absolute inset-0 h-full w-full object-contain p-4 transition-transform group-hover:scale-[1.02]" />
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center text-slate-400">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3 3h18v18H3V3z" />
                                        </svg>
                                    </div>
                                @endif

                                @if (!empty($product->original_price) && (float)$product->original_price > (float)$product->base_price)
                                    @php $pct = round((1 - ((float)$product->base_price / (float)$product->original_price)) * 100); @endphp
                                    <span class="absolute top-2 left-2 inline-flex items-center h-6 px-2 rounded bg-amber-500 text-slate-900 text-xs font-bold">-{{ $pct }}%</span>
                                @endif
                            </div>
                            <div class="p-3">
                                <div class="text-xs text-slate-500">{{ $product->category?->name ?? $pageLabel }}</div>
                                <div class="mt-1 text-sm font-semibold text-slate-900">{{ $product->name }}</div>
                                <div class="mt-2 text-sm font-extrabold text-emerald-700">
                                    {{ number_format((float) $product->base_price, 0, ',', '.') }} VNĐ
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full bg-white border border-slate-200 rounded-xl p-8 text-center text-sm text-slate-600">
                            Không tìm thấy sản phẩm phù hợp.
                        </div>
                    @endforelse
                </div>

                <div class="mt-8 flex justify-center">
                    {{ $products->links() }}
                </div>
            </section>
        </div>
    </main>

    <footer class="bg-slate-900 text-slate-200 mt-10">
        <div class="max-w-6xl mx-auto px-4 py-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="text-emerald-400 font-extrabold italic">VT STORE</div>
                    <p class="mt-3 text-sm text-slate-300">
                        Elite Football Performance. Chuyên cung cấp giày đá bóng chính hãng và phụ kiện thể thao cao cấp.
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-white">Thông tin liên hệ</p>
                    <ul class="mt-3 space-y-2 text-sm text-slate-300">
                        <li>contact@vtstore.vn</li>
                        <li>Hotline: 1900 1234</li>
                    </ul>
                </div>

                <div>
                    <p class="text-sm font-semibold text-white">Chính sách</p>
                    <ul class="mt-3 space-y-2 text-sm text-slate-300">
                        <li>Chính sách bảo mật</li>
                        <li>Chính sách đổi trả</li>
                    </ul>
                </div>

                <div>
                    <p class="text-sm font-semibold text-white">Dịch vụ</p>
                    <ul class="mt-3 space-y-2 text-sm text-slate-300">
                        <li>Điều khoản dịch vụ</li>
                        <li>Hướng dẫn mua hàng</li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-white/10 text-xs text-slate-400 flex items-center justify-between">
                <span>© {{ date('Y') }} VT Store. All rights reserved.</span>
                <span class="hidden sm:inline">{{ $pageLabel }}</span>
            </div>
        </div>
    </footer>

    <script>
        (function () {
            const range = document.getElementById('max-price-range');
            const input = document.getElementById('max-price-input');
            if (!range || !input) return;
            range.addEventListener('input', function () {
                input.value = String(range.value);
            });
        })();
    </script>

</body>
</html>
