<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Giỏ hàng - {{ config('app.name', 'VT Store') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">

    @php $cartCount = \App\Support\Cart::count(); @endphp

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

                    @auth
                        <a href="{{ route('orders.index') }}" class="hidden md:inline text-xs font-semibold tracking-wide uppercase text-slate-700 hover:text-slate-900">Đơn hàng</a>
                    @else
                        <a href="{{ route('orders.track.form') }}" class="hidden md:inline text-xs font-semibold tracking-wide uppercase text-slate-700 hover:text-slate-900">Tra cứu đơn</a>
                    @endauth
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

    <main class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-extrabold tracking-tight">GIỎ HÀNG CỦA BẠN</h1>

        @if ($items === [])
            <div class="mt-6 bg-white border border-slate-200 rounded-2xl p-10 text-center">
                <p class="text-slate-600">Giỏ hàng đang trống.</p>
                <a href="{{ route('products.index') }}" class="mt-5 inline-flex items-center h-10 px-5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800">
                    Xem sản phẩm
                </a>
            </div>
        @else
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                <section class="lg:col-span-8">
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                        <div class="hidden md:grid grid-cols-12 gap-3 px-6 py-4 border-b border-slate-200 text-xs font-semibold tracking-wide uppercase text-slate-500">
                            <div class="col-span-7">Sản phẩm</div>
                            <div class="col-span-2">Giá</div>
                            <div class="col-span-2">Số lượng</div>
                            <div class="col-span-1 text-right whitespace-nowrap">Thành tiền</div>
                        </div>

                        @foreach ($items as $key => $item)
                            @php $line = (float) $item['price'] * (int) $item['quantity']; @endphp
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 px-6 py-5 border-b border-slate-200 items-center">
                                <div class="md:col-span-6 flex items-center gap-4">
                                    <div class="h-20 w-20 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0">
                                        @if (!empty($item['image_path']))
                                            <img src="{{ asset('storage/' . $item['image_path']) }}" alt="{{ $item['name'] }}" class="h-full w-full object-contain" />
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-slate-400">
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3 3h18v18H3V3z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="min-w-0 space-y-2">
                                        @php
                                            $nameLines = preg_split("/\r\n|\r|\n/u", (string) ($item['name'] ?? '')) ?: [];
                                            $nameLines = array_values(array_filter(array_map('trim', $nameLines), fn ($v) => $v !== ''));
                                        @endphp

                                        <div class="text-sm font-semibold text-slate-900 leading-relaxed break-words">
                                            {{ $nameLines[0] ?? (string) ($item['name'] ?? '') }}
                                        </div>

                                        @if (count($nameLines) > 1)
                                            <div class="space-y-1">
                                                @foreach (array_slice($nameLines, 1) as $line)
                                                    <div class="text-xs font-medium text-slate-700 leading-relaxed break-words">{{ $line }}</div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="text-xs text-slate-500 leading-relaxed">
                                            @if (!empty($item['size']))
                                                Kích cỡ: <span class="font-semibold text-slate-700">{{ $item['size'] }}</span>
                                            @else
                                                Kích cỡ: <span class="font-semibold text-slate-700">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="md:col-span-2 text-sm text-slate-700 font-semibold">
                                    {{ number_format((float) $item['price'], 0, ',', '.') }}đ
                                </div>

                                <div class="md:col-span-2">
                                    <form method="POST" action="{{ route('cart.update', ['key' => $key]) }}" class="inline-flex items-center rounded-lg border border-slate-200 bg-white overflow-hidden">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            type="button"
                                            class="h-9 w-9 inline-flex items-center justify-center text-slate-700 hover:bg-slate-50"
                                            onclick="const f=this.form; const i=f.querySelector('input[name=quantity]'); i.value=Math.max(0, (+i.value||0)-1); f.submit();"
                                            aria-label="Giảm số lượng"
                                        >−</button>
                                        <input
                                            type="number"
                                            name="quantity"
                                            value="{{ (int) $item['quantity'] }}"
                                            min="0"
                                            max="99"
                                            class="h-9 w-12 text-center text-sm outline-none border-x border-slate-200"
                                        />
                                        <button
                                            type="button"
                                            class="h-9 w-9 inline-flex items-center justify-center text-slate-700 hover:bg-slate-50"
                                            onclick="const f=this.form; const i=f.querySelector('input[name=quantity]'); i.value=Math.min(99, (+i.value||0)+1); f.submit();"
                                            aria-label="Tăng số lượng"
                                        >+</button>
                                    </form>
                                </div>

                                <div class="md:col-span-2 flex items-center justify-between md:justify-end gap-4">
                                    <div class="text-sm font-extrabold text-amber-600 md:text-right">
                                        {{ number_format((float) $line, 0, ',', '.') }}đ
                                    </div>

                                    <form method="POST" action="{{ route('cart.remove', ['key' => $key]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:text-red-600 hover:border-red-200" aria-label="Xóa">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 flex items-center justify-between gap-4 flex-wrap">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center h-10 px-5 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-white">
                            ← Tiếp tục mua hàng
                        </a>

                        <form method="POST" action="{{ route('cart.clear') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center h-10 px-5 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold hover:border-red-200 hover:text-red-600">
                                Xóa giỏ hàng
                            </button>
                        </form>
                    </div>
                </section>

                <aside class="lg:col-span-4">
                    <div class="bg-slate-900 text-white rounded-2xl p-6 sticky top-24">
                        <h2 class="text-lg font-extrabold tracking-wide">TÓM TẮT ĐƠN HÀNG</h2>

                        <div class="mt-5 space-y-3 text-sm">
                            <div class="flex items-center justify-between text-slate-200">
                                <span>Thành tiền</span>
                                <span class="font-semibold text-white">{{ number_format((float) $totals['subtotal'], 0, ',', '.') }}đ</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-200">
                                <span>Phí vận chuyển</span>
                                <span class="font-semibold text-emerald-300">FREE</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-200">
                                <span>Thuế (gồm)</span>
                                <span class="font-semibold">Đã bao gồm</span>
                            </div>

                            <div class="pt-4 mt-4 border-t border-white/10 flex items-end justify-between">
                                <span class="text-slate-200">Tổng cộng</span>
                                <span class="text-2xl font-extrabold">{{ number_format((float) $totals['subtotal'], 0, ',', '.') }}đ</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.create') }}" class="mt-6 inline-flex items-center justify-center w-full h-12 rounded-xl bg-emerald-600 text-white text-sm font-extrabold tracking-wide hover:bg-emerald-500">
                            TIẾN HÀNH ĐẶT HÀNG
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>

                        <div class="mt-4 text-xs text-slate-300">
                            <div class="flex items-start gap-2">
                                <svg class="mt-0.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Giao dịch an toàn với mã hóa SSL.</span>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        @endif
    </main>

    @include('store.partials.ai-chat-widget')

</body>
</html>