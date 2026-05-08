<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thanh toán - {{ config('app.name', 'VT Store') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">

    @php
        $cartCount = \App\Support\Cart::count();
        $subtotal = (float) ($totals['subtotal'] ?? 0);
        $shippingFee = 0.0;
        $grandTotal = $subtotal + $shippingFee;
    @endphp

    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="h-16 flex items-center gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                    <span class="text-lg font-extrabold italic tracking-tight">VTSTORE</span>
                </a>

                <nav class="hidden md:flex items-center gap-6 text-xs font-semibold tracking-wide uppercase text-slate-700">
                    <a class="hover:text-slate-900" href="{{ route('home') }}">Trang chủ</a>
                    <a class="hover:text-slate-900" href="{{ route('products.index') }}">Sản phẩm</a>
                    <a class="hover:text-slate-900" href="{{ route('products.index', ['type' => 'giay']) }}">Bộ sưu tập</a>
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

    <main class="max-w-6xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <section class="lg:col-span-8">
                <h1 class="text-2xl font-extrabold tracking-tight">Thông tin nhận hàng</h1>
                <div class="mt-2 h-0.5 w-16 bg-emerald-600"></div>

                <form class="mt-6 bg-white border border-slate-200 rounded-2xl p-6 md:p-7" method="POST" action="{{ route('checkout.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700">Họ và tên</label>
                            <input
                                name="customer_name"
                                value="{{ old('customer_name', $user?->name) }}"
                                required
                                class="mt-2 w-full h-11 px-4 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                            />
                            <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700">Số điện thoại</label>
                            <input
                                name="customer_phone"
                                value="{{ old('customer_phone') }}"
                                required
                                class="mt-2 w-full h-11 px-4 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                            />
                            <x-input-error :messages="$errors->get('customer_phone')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-xs font-semibold text-slate-700">Email</label>
                        <input
                            type="email"
                            name="customer_email"
                            value="{{ old('customer_email', $user?->email) }}"
                            required
                            class="mt-2 w-full h-11 px-4 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                        />
                        <x-input-error :messages="$errors->get('customer_email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <label class="block text-xs font-semibold text-slate-700">Địa chỉ chi tiết</label>
                        <input
                            name="shipping_address"
                            value="{{ old('shipping_address') }}"
                            required
                            placeholder="Số nhà, tên đường, phường/xã..."
                            class="mt-2 w-full h-11 px-4 rounded-xl border border-slate-200 bg-white text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                        />
                        <x-input-error :messages="$errors->get('shipping_address')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <label class="block text-xs font-semibold text-slate-700">Ghi chú đơn hàng (tùy chọn)</label>
                        <textarea
                            name="note"
                            rows="4"
                            placeholder="Lưu ý về thời gian giao hàng, chỉ dẫn địa chỉ..."
                            class="mt-2 w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                        >{{ old('note') }}</textarea>
                        <x-input-error :messages="$errors->get('note')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full h-12 rounded-xl bg-slate-900 text-white text-sm font-extrabold tracking-wide hover:bg-slate-800">
                            XÁC NHẬN ĐẶT HÀNG
                            <span class="ml-2">→</span>
                        </button>
                    </div>
                </form>
            </section>

            <aside class="lg:col-span-4">
                <div class="bg-white border border-slate-200 rounded-2xl p-6 sticky top-24">
                    <h2 class="text-lg font-extrabold">Đơn hàng của bạn</h2>
                    <div class="mt-4 h-px bg-slate-200"></div>

                    <div class="mt-4 space-y-4">
                        @foreach ($items as $item)
                            <div class="flex items-start gap-3">
                                <div class="h-14 w-16 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden shrink-0">
                                    @if (!empty($item['image_path']))
                                        <img src="{{ asset('storage/' . $item['image_path']) }}" alt="{{ $item['name'] }}" class="h-full w-full object-contain" />
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="text-sm font-semibold text-slate-900 leading-snug">{{ $item['name'] }}</div>
                                    <div class="mt-1 text-[11px] text-slate-500">
                                        SIZE: {{ $item['size'] ?: '-' }} · x{{ (int) $item['quantity'] }}
                                    </div>
                                </div>
                                <div class="text-sm font-extrabold text-emerald-700 whitespace-nowrap">
                                    {{ number_format(((float) $item['price']) * (int) $item['quantity'], 0, ',', '.') }}đ
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 border-t border-slate-200 pt-4 space-y-2 text-sm">
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Tạm tính</span>
                            <span class="font-semibold text-slate-900">{{ number_format($subtotal, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Phí vận chuyển</span>
                            <span class="font-semibold text-slate-900">{{ $shippingFee > 0 ? number_format($shippingFee, 0, ',', '.') . 'đ' : 'Miễn phí' }}</span>
                        </div>
                        <div class="mt-3 pt-3 border-t border-dashed border-slate-200 flex items-end justify-between">
                            <span class="text-base font-extrabold text-slate-900">Tổng cộng</span>
                            <span class="text-xl font-extrabold text-slate-900">{{ number_format($grandTotal, 0, ',', '.') }}đ</span>
                        </div>
                    </div>

                    <div class="mt-5">
                        <a href="{{ route('cart.index') }}" class="block text-center text-sm text-slate-600 hover:text-slate-900">
                            ← Quay lại giỏ hàng
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </main>

</body>
</html>