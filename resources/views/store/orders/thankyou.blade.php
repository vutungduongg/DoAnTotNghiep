<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đặt hàng thành công - {{ config('app.name', 'VT Store') }}</title>

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
                    <a class="hover:text-slate-900" href="{{ route('products.index') }}">Sản phẩm</a>
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

                    @auth
                        <a href="{{ route('orders.index') }}" class="hidden md:inline text-xs font-semibold tracking-wide uppercase text-slate-700 hover:text-slate-900">Đơn hàng</a>
                    @else
                        <a href="{{ route('orders.track.form') }}" class="hidden md:inline text-xs font-semibold tracking-wide uppercase text-slate-700 hover:text-slate-900">Tra cứu đơn</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-12">
        <section class="max-w-2xl mx-auto text-center">
            <div class="mx-auto h-20 w-20 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>
            <h1 class="mt-6 text-4xl font-extrabold tracking-tight">Đặt hàng thành công!</h1>
            <p class="mt-3 text-sm text-slate-600">Cảm ơn bạn đã tin tưởng và lựa chọn VT Store. Đơn hàng của bạn đang được chuẩn bị để giao tới bạn.</p>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                <div class="bg-white border border-slate-200 rounded-2xl p-6">
                    <div class="text-xs font-semibold tracking-wide uppercase text-slate-500">Mã đơn hàng</div>
                    <div class="mt-2 text-xl font-extrabold">{{ $order->order_number }}</div>
                    <div class="mt-5 h-px bg-slate-200"></div>
                    <div class="mt-5 text-xs font-semibold tracking-wide uppercase text-slate-500">Tổng thanh toán</div>
                    <div class="mt-2 text-2xl font-extrabold text-emerald-700">{{ number_format((float) $order->total, 0, ',', '.') }}đ</div>
                </div>

                <div class="bg-slate-900 text-white rounded-2xl p-6">
                    <div class="text-xs font-semibold tracking-wide uppercase text-slate-300">Thời gian giao dự kiến</div>
                    <div class="mt-2 text-2xl font-extrabold">2-4 ngày làm việc</div>
                    <div class="mt-5 flex items-center gap-2 text-sm text-slate-200">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 01-3 0m3 0h9.75m-9.75 0H5.25m14.25 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 01-3 0m3 0h.75a.75.75 0 00.75-.75V14.25m-1.5 4.5h-3.75M3 13.5V6.75A.75.75 0 013.75 6h11.5a.75.75 0 01.75.75v11.25m0-4.5h4.5m0 0l-1.5-3.75A1.5 1.5 0 0017.1 9H15.75"/></svg>
                        <span>Đơn vị vận chuyển: <span class="font-semibold">VT Express Elite</span></span>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center h-11 px-7 rounded-xl bg-slate-900 text-white text-sm font-extrabold tracking-wide hover:bg-slate-800">
                    TIẾP TỤC MUA SẮM
                </a>

                @auth
                    <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center justify-center h-11 px-7 rounded-xl border border-slate-300 text-slate-900 text-sm font-extrabold tracking-wide hover:bg-white">
                        XEM CHI TIẾT ĐƠN HÀNG
                    </a>
                @else
                    <a href="{{ route('orders.track.form') }}" class="inline-flex items-center justify-center h-11 px-7 rounded-xl border border-slate-300 text-slate-900 text-sm font-extrabold tracking-wide hover:bg-white">
                        XEM CHI TIẾT ĐƠN HÀNG
                    </a>
                @endauth
            </div>

            <div class="mt-10 text-xs text-slate-600">
                Cần hỗ trợ? Liên hệ hotline <span class="font-extrabold">1900 8888</span>
            </div>
        </section>
    </main>

    @include('store.partials.ai-chat-widget')

</body>
</html>