<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} - {{ config('app.name', 'VT Store') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">

    @php
        $cartCount = \App\Support\Cart::count();
        $selectedVariantId = old('variant_id') ?? ($product->variants->first()?->id);
        $qty = (int) old('quantity', 1);
        $qty = max(1, min(99, $qty));
        $hasVariantPrices = $product->variants->whereNotNull('price')->count() > 0;
    @endphp

    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="h-16 flex items-center gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                    <span class="text-lg font-extrabold italic tracking-tight">VTSTORE</span>
                </a>

                <nav class="hidden md:flex items-center gap-6 text-xs font-semibold tracking-wide uppercase text-slate-700">
                    <a class="hover:text-slate-900" href="{{ route('home') }}">Trang chủ</a>
                    <a class="hover:text-slate-900" href="{{ route('products.index', ['type' => 'giay']) }}">Giày</a>
                    <a class="hover:text-slate-900" href="{{ route('products.index', ['type' => 'ao_dau']) }}">Quần áo</a>
                    <a class="hover:text-slate-900" href="{{ route('products.index', ['category' => 'phu-kien']) }}">Phụ kiện</a>
                </nav>

                <form class="flex-1 flex justify-center" method="GET" action="{{ route('products.index') }}">
                    <div class="w-full max-w-lg relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <input
                            name="q"
                            value="{{ request('q') }}"
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

    @if (session('status'))
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="px-4 py-3 rounded-xl text-sm bg-emerald-50 border border-emerald-200 text-emerald-900">
                {{ session('status') }}
            </div>
        </div>
    @endif

    <main class="max-w-6xl mx-auto px-4 py-6">
        <nav class="text-xs text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-slate-900">Trang chủ</a>
            <span class="mx-1">·</span>
            <a href="{{ route('products.index') }}" class="hover:text-slate-900">Sản phẩm</a>
            @if ($product->category)
                <span class="mx-1">·</span>
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-slate-900">{{ $product->category->name }}</a>
            @endif
            <span class="mx-1">·</span>
            <span class="text-slate-700">{{ $product->name }}</span>
        </nav>

        <section class="mt-5 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-7">
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="aspect-square bg-slate-50 flex items-center justify-center">
                        @if ($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-contain p-6" />
                        @else
                            <div class="h-full w-full flex items-center justify-center text-slate-400">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3 3h18v18H3V3z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                @if ($product->category)
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-xs font-semibold tracking-wide uppercase text-slate-500 hover:text-slate-900">
                        {{ $product->category->name }}
                    </a>
                @endif

                <h1 class="mt-2 text-2xl md:text-3xl font-bold leading-tight text-slate-900">{{ $product->name }}</h1>

                <div class="mt-4 flex items-end gap-3">
                    <div class="text-2xl font-extrabold text-amber-600">
                        {{ number_format((float) $product->base_price, 0, ',', '.') }}đ
                    </div>
                    @if ($hasVariantPrices)
                        <div class="text-sm text-slate-500">(Giá có thể thay đổi theo size)</div>
                    @endif
                </div>

                @if ($product->description)
                    <p class="mt-4 text-sm text-slate-600 leading-7">
                        {{ $product->description }}
                    </p>
                @endif

                <form class="mt-6 space-y-5" method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}" />

                    @if ($product->variants->count() > 0)
                        <div>
                            <div class="flex items-center justify-between">
                                <p class="text-xs font-semibold tracking-wide uppercase text-slate-700">Chọn size</p>
                            </div>
                            <div class="mt-3 grid grid-cols-5 gap-2">
                                @foreach ($product->variants as $variant)
                                    <label class="block">
                                        <input
                                            type="radio"
                                            name="variant_id"
                                            value="{{ $variant->id }}"
                                            class="peer sr-only"
                                            {{ (string) $variant->id === (string) $selectedVariantId ? 'checked' : '' }}
                                            required
                                        />
                                        <span class="inline-flex w-full items-center justify-center h-10 rounded border border-slate-200 text-sm text-slate-700 peer-checked:border-slate-900 peer-checked:bg-slate-900 peer-checked:text-white">
                                            {{ $variant->size }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('variant_id')" class="mt-2" />
                        </div>
                    @endif

                    <div>
                        <p class="text-xs font-semibold tracking-wide uppercase text-slate-700">Số lượng</p>
                        <div class="mt-3 inline-flex items-center rounded-lg border border-slate-200 bg-white overflow-hidden">
                            <button
                                type="button"
                                class="h-10 w-10 inline-flex items-center justify-center text-slate-700 hover:bg-slate-50"
                                onclick="const i=this.parentElement.querySelector('input[name=quantity]'); i.value=Math.max(1, (+i.value||1)-1);"
                                aria-label="Giảm số lượng"
                            >
                                −
                            </button>
                            <input
                                name="quantity"
                                type="number"
                                min="1"
                                max="99"
                                value="{{ $qty }}"
                                class="h-10 w-14 text-center text-sm outline-none border-x border-slate-200"
                            />
                            <button
                                type="button"
                                class="h-10 w-10 inline-flex items-center justify-center text-slate-700 hover:bg-slate-50"
                                onclick="const i=this.parentElement.querySelector('input[name=quantity]'); i.value=Math.min(99, (+i.value||1)+1);"
                                aria-label="Tăng số lượng"
                            >
                                +
                            </button>
                        </div>
                    </div>

                    <div class="pt-1">
                        <button type="submit" class="w-full h-12 rounded-xl bg-amber-400 text-slate-900 text-sm font-extrabold tracking-wide hover:bg-amber-300">
                            MUA HÀNG
                        </button>
                        <a href="{{ route('cart.index') }}" class="mt-3 block text-center text-sm text-slate-600 hover:text-slate-900">
                            Xem giỏ hàng
                        </a>
                    </div>
                </form>

            </div>
        </section>

        <section class="mt-10">
            <div class="border-b border-slate-200">
                <div class="flex gap-6 text-sm font-semibold">
                    <a href="#mo-ta" class="py-3 border-b-2 border-slate-900 text-slate-900">Mô tả sản phẩm</a>
                    <a href="#huong-dan" class="py-3 border-b-2 border-transparent text-slate-600 hover:text-slate-900">Hướng dẫn bảo quản</a>
                </div>
            </div>

            <div id="mo-ta" class="mt-5 grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-8 bg-white border border-slate-200 rounded-xl p-6">
                    <h2 class="text-sm font-extrabold tracking-wide uppercase text-slate-900">Kỹ thuật & Hiệu suất</h2>
                    <p class="mt-3 text-sm text-slate-600 leading-7">
                        {{ $product->description ?: 'Thông tin mô tả đang được cập nhật.' }}
                    </p>
                </div>
                <div id="huong-dan" class="lg:col-span-4 bg-slate-900 text-white rounded-xl p-6">
                    <h3 class="text-sm font-extrabold tracking-wide uppercase">Hướng dẫn bảo quản</h3>
                    <p class="mt-3 text-sm text-slate-200 leading-7">
                        Đang cập nhật.
                    </p>
                </div>
            </div>
        </section>

        @if (!empty($relatedProducts) && $relatedProducts->count() > 0)
            <section class="mt-12">
                <div class="flex items-center justify-between gap-4">
                    <h2 class="text-lg font-semibold">Sản phẩm liên quan</h2>
                    <a href="{{ route('products.index') }}" class="text-sm text-slate-600 hover:text-slate-900">Xem tất cả</a>
                </div>
                <div class="mt-5 grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($relatedProducts as $rp)
                        <a href="{{ route('products.show', $rp) }}" class="group bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-sm transition">
                            <div class="aspect-square bg-slate-100">
                                @if ($rp->image_path)
                                    <img src="{{ asset('storage/' . $rp->image_path) }}" alt="{{ $rp->name }}" class="h-full w-full object-contain group-hover:scale-[1.02] transition" />
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-slate-400">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3 3h18v18H3V3z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <p class="text-xs text-slate-500">{{ $rp->category?->name ?? 'Sản phẩm' }}</p>
                                <h3 class="mt-1 text-sm font-semibold text-slate-900">{{ $rp->name }}</h3>
                                <div class="mt-2 text-sm font-bold text-slate-900">
                                    {{ number_format((float) $rp->base_price, 0, ',', '.') }}đ
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </main>

</body>
</html>