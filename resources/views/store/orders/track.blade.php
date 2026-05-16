<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tra cứu đơn hàng - {{ config('app.name', 'VT Store') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">

    @php
        $cartCount = \App\Support\Cart::count();
    @endphp

    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="h-16 flex items-center gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                    <span class="text-lg font-extrabold italic tracking-tight">VTStore</span>
                </a>

                <nav class="hidden md:flex items-center gap-6 text-xs font-semibold tracking-wide text-slate-700">
                    <a class="hover:text-slate-900" href="{{ route('products.index') }}">Tất cả sản phẩm</a>
                    <a class="hover:text-slate-900" href="{{ route('products.index', ['type' => 'giay']) }}">Giày bóng đá</a>
                    <a class="hover:text-slate-900" href="{{ route('products.index', ['type' => 'ao_dau']) }}">Áo thể thao</a>
                </nav>

                <form class="flex-1 flex justify-center" method="GET" action="{{ route('products.index') }}">
                    <div class="w-full max-w-lg relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <input
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Tìm sản phẩm..."
                            class="w-full h-10 pl-9 pr-3 rounded-full border border-slate-200 bg-slate-100 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                        />
                    </div>
                </form>

                <div class="flex items-center gap-3 shrink-0 text-xs font-semibold tracking-wide uppercase">
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

                    @auth
                        <a href="{{ route('orders.index') }}" class="hidden md:inline text-xs font-semibold tracking-wide uppercase text-slate-700 hover:text-slate-900">Đơn hàng</a>
                    @else
                        <a href="{{ route('orders.track.form') }}" class="hidden md:inline text-xs font-semibold tracking-wide uppercase text-slate-700 hover:text-slate-900">Tra cứu đơn</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-10">
        <div class="max-w-xl mx-auto">
            <div class="text-center">
                <div class="mx-auto h-14 w-14 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-center">
                    <svg class="h-6 w-6 text-emerald-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <h1 class="mt-4 text-2xl font-extrabold tracking-tight">Tra cứu đơn hàng</h1>
                <p class="mt-2 text-sm text-slate-600">Nhập mã đơn và email để xem trạng thái đơn hàng</p>
            </div>

            <div class="mt-6 bg-white border border-slate-200 rounded-2xl p-6">
                <form method="POST" action="{{ route('orders.track') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold tracking-wide uppercase text-slate-600">Mã đơn hàng <span class="text-red-600">*</span></label>
                        <input
                            name="order_number"
                            value="{{ old('order_number') }}"
                            required
                            placeholder="ORD-YYYYMMDD-XXXXXXXX"
                            class="mt-2 w-full h-11 px-4 rounded-xl border border-slate-200 bg-white text-sm font-mono text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-600/15 focus:border-emerald-300"
                        />
                        <x-input-error :messages="$errors->get('order_number')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold tracking-wide uppercase text-slate-600">Email đặt hàng <span class="text-red-600">*</span></label>
                        <input
                            type="email"
                            name="customer_email"
                            value="{{ old('customer_email') }}"
                            required
                            placeholder="email@example.com"
                            class="mt-2 w-full h-11 px-4 rounded-xl border border-slate-200 bg-white text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-600/15 focus:border-emerald-300"
                        />
                        <x-input-error :messages="$errors->get('customer_email')" class="mt-2" />
                    </div>

                    <button type="submit" class="w-full h-12 rounded-xl bg-emerald-600 text-white text-sm font-extrabold tracking-wide hover:bg-emerald-500">
                        Tra cứu đơn hàng
                    </button>
                </form>
            </div>

            <div class="mt-5 text-center text-sm text-slate-600">
                Chưa có đơn hàng?
                <a href="{{ route('products.index') }}" class="font-semibold text-emerald-700 hover:text-emerald-600">Mua sắm ngay</a>
            </div>
        </div>
    </main>

    @include('store.partials.ai-chat-widget')

</body>
</html>