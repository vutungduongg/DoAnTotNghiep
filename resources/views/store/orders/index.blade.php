<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đơn hàng - {{ config('app.name', 'VT Store') }}</title>

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
                    @if ($status)
                        <input type="hidden" name="status" value="{{ $status }}" />
                    @endif

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

    <main class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight">ĐƠN HÀNG CỦA BẠN</h1>
                <p class="mt-1 text-sm text-slate-600">Theo dõi trạng thái và lịch sử mua hàng</p>
            </div>
        </div>

        {{-- STATUS TABS --}}
        <div class="mt-6 flex flex-wrap gap-2">
            <a
                href="{{ route('orders.index') }}"
                class="inline-flex items-center h-9 px-4 rounded-full border text-sm font-semibold transition {{ empty($status) ? 'bg-slate-900 border-slate-900 text-white' : 'bg-white border-slate-200 text-slate-700 hover:border-slate-300' }}"
            >
                Tất cả
            </a>

            @foreach ($statuses as $st)
                @php $count = $counts[$st] ?? 0; @endphp
                <a
                    href="{{ route('orders.index', ['status' => $st]) }}"
                    class="inline-flex items-center h-9 px-4 rounded-full border text-sm font-semibold transition {{ ($status === $st) ? 'bg-slate-900 border-slate-900 text-white' : 'bg-white border-slate-200 text-slate-700 hover:border-slate-300' }}"
                >
                    {{ $st }}
                    <span class="ml-2 inline-flex items-center justify-center min-w-6 h-6 px-2 rounded-full text-xs font-extrabold {{ ($status === $st) ? 'bg-white/15 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $count }}</span>
                </a>
            @endforeach
        </div>

        {{-- LIST --}}
        <section class="mt-6 bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div class="hidden md:grid grid-cols-12 gap-3 px-6 py-4 border-b border-slate-200 text-xs font-semibold tracking-wide uppercase text-slate-500">
                <div class="col-span-4">Mã đơn</div>
                <div class="col-span-3">Trạng thái</div>
                <div class="col-span-2">Tổng tiền</div>
                <div class="col-span-2">Ngày tạo</div>
                <div class="col-span-1 text-right"></div>
            </div>

            @forelse ($orders as $order)
                @php
                    $badge = match((string) $order->status) {
                        'Chờ xử lý'  => 'bg-amber-50 text-amber-700 border-amber-200',
                        'Đang xử lý' => 'bg-blue-50 text-blue-700 border-blue-200',
                        'Đang giao'  => 'bg-violet-50 text-violet-700 border-violet-200',
                        'Hoàn thành' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'Đã hủy'     => 'bg-red-50 text-red-700 border-red-200',
                        default      => 'bg-slate-50 text-slate-700 border-slate-200',
                    };
                @endphp

                <div class="px-6 py-5 border-b border-slate-200 last:border-b-0">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 md:items-center">
                        <div class="md:col-span-4">
                            <div class="text-xs text-slate-500 md:hidden">Mã đơn</div>
                            <div class="font-mono text-sm font-bold text-slate-900">{{ $order->order_number }}</div>
                        </div>

                        <div class="md:col-span-3">
                            <div class="text-xs text-slate-500 md:hidden">Trạng thái</div>
                            <span class="inline-flex items-center h-7 px-3 rounded-full border text-xs font-bold {{ $badge }}">{{ $order->status }}</span>
                        </div>

                        <div class="md:col-span-2">
                            <div class="text-xs text-slate-500 md:hidden">Tổng tiền</div>
                            <div class="text-sm font-extrabold text-slate-900">{{ number_format((float) $order->total, 0, ',', '.') }}đ</div>
                        </div>

                        <div class="md:col-span-2">
                            <div class="text-xs text-slate-500 md:hidden">Ngày tạo</div>
                            <div class="text-sm text-slate-600">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                        </div>

                        <div class="md:col-span-1 md:text-right">
                            <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center justify-center h-9 px-4 rounded-xl border border-slate-300 text-slate-900 text-sm font-semibold hover:bg-white">
                                Xem
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-14 text-center">
                    <p class="text-sm text-slate-600">Chưa có đơn hàng nào.</p>
                    <a href="{{ route('products.index') }}" class="mt-4 inline-flex items-center justify-center h-11 px-6 rounded-xl bg-slate-900 text-white text-sm font-extrabold tracking-wide hover:bg-slate-800">
                        MUA SẮM NGAY
                    </a>
                </div>
            @endforelse
        </section>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </main>

    @include('store.partials.ai-chat-widget')

</body>
</html>