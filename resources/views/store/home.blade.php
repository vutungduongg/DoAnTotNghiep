<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'VT Store') }}</title>

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
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded bg-slate-900 text-white text-xs font-bold tracking-wide">VT</span>
                    <span class="font-semibold tracking-wide">VT STORE</span>
                </a>

                <nav class="hidden md:flex items-center gap-6 text-sm text-slate-700">
                    @foreach ($categories->take(3) as $category)
                        <a class="hover:text-slate-900" href="{{ route('products.index', ['category' => $category->slug]) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
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
                            class="w-full h-10 pl-9 pr-3 rounded-full border border-slate-200 bg-white text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                        />
                    </div>
                </form>

                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('cart.index') }}" class="relative inline-flex items-center justify-center h-10 w-10 rounded-full hover:bg-slate-100" aria-label="Giỏ hàng">
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
                        <a href="{{ route('profile.edit') }}" class="text-sm text-slate-700 hover:text-slate-900">Tài khoản</a>
                    @else
                        <a href="{{ route('register') }}" class="text-sm text-slate-700 hover:text-slate-900">Đăng ký</a>
                        <a href="{{ route('login') }}" class="inline-flex items-center h-9 px-4 rounded bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800">Đăng nhập</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main>
        <section class="bg-slate-900 text-white">
            <div class="max-w-6xl mx-auto px-4">
                <div class="py-10 md:py-14 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                    <div>
                        <span class="inline-flex items-center h-6 px-2 rounded bg-emerald-600/20 text-emerald-200 text-xs font-semibold">NEW COLLECTION 2024</span>
                        <h1 class="mt-4 text-3xl md:text-4xl font-bold leading-tight">CHINH PHỤC MỌI TRẬN ĐẤU</h1>
                        <p class="mt-3 text-slate-200 text-sm md:text-base max-w-xl">
                            Khám phá bộ sưu tập trang phục và thiết bị bóng đá cao cấp, phù hợp cho mọi phong cách thi đấu.
                        </p>
                        <div class="mt-6 flex items-center gap-3">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center h-10 px-5 rounded bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-500">
                                MUA NGAY
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center h-10 px-5 rounded border border-white/25 text-white text-sm font-semibold hover:bg-white/10">BỘ SƯU TẬP</a>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-gradient-to-br from-slate-800 via-slate-900 to-slate-950 border border-white/10">
                            <div class="h-full w-full bg-gradient-to-br from-emerald-500/10 via-slate-900 to-blue-500/10"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-10">
            <div class="max-w-6xl mx-auto px-4">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold">Sản Phẩm Nổi Bật</h2>
                        <div class="mt-2 h-0.5 w-16 bg-emerald-600"></div>
                    </div>
                    <a href="{{ route('products.index') }}" class="text-sm text-slate-600 hover:text-slate-900">Xem tất cả</a>
                </div>

                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($featuredProducts as $product)
                        <a href="{{ route('products.show', $product) }}" class="group bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-sm transition">
                            <div class="aspect-square bg-slate-100">
                                @if ($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-contain group-hover:scale-[1.02] transition" />
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-slate-400">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3 3h18v18H3V3z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <p class="text-xs text-slate-500">{{ $product->category?->name ?? 'Sản phẩm' }}</p>
                                <h3 class="mt-1 text-sm font-semibold text-slate-900">{{ $product->name }}</h3>
                                <div class="mt-2 text-sm font-bold text-slate-900">
                                    {{ number_format((float) $product->base_price, 0, ',', '.') }}đ
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="py-8">
            <div class="max-w-6xl mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="lg:col-span-2 rounded-2xl overflow-hidden bg-slate-900 text-white relative">
                        <div class="absolute inset-0 opacity-60 bg-gradient-to-br from-emerald-500/20 via-slate-900 to-blue-500/20"></div>
                        <div class="relative p-6 md:p-8 flex items-end min-h-[240px]">
                            <div>
                                <h3 class="text-2xl font-bold">Dòng Sản Phẩm Pro Training</h3>
                                <p class="mt-2 text-sm text-slate-200 max-w-xl">
                                    Trang bị chuẩn chỉnh cho tập luyện và thi đấu — tối ưu sự thoải mái và độ bền.
                                </p>
                                <a href="{{ route('products.index') }}" class="mt-4 inline-flex items-center h-10 px-5 rounded bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-500">
                                    Khám phá ngay
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4">
                        <div class="bg-white rounded-2xl border border-slate-200 p-5">
                            <div class="flex items-start gap-3">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-slate-900 text-white">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 003 0m-3 0a1.5 1.5 0 003 0m-3 0H6.75m4.5 0H17.25m0 0a1.5 1.5 0 003 0m-3 0a1.5 1.5 0 003 0m-3 0h-1.5m-9-13.5h10.5l2.25 6.75H5.25l2.25-6.75z" />
                                    </svg>
                                </span>
                                <div>
                                    <h4 class="font-semibold">GIAO HÀNG TỐC HÀNH</h4>
                                    <p class="mt-1 text-sm text-slate-600">Nhận hàng trong vòng 2h tại khu vực nội thành.</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl border border-slate-200 p-5">
                            <div class="flex items-start gap-3">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                <div>
                                    <h4 class="font-semibold">CAM KẾT CHÍNH HÃNG</h4>
                                    <p class="mt-1 text-sm text-slate-600">Hoàn tiền 200% nếu phát hiện hàng giả, hàng kém chất lượng.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-12 bg-white border-t border-slate-200">
            <div class="max-w-6xl mx-auto px-4 text-center">
                <p class="text-xs font-semibold tracking-widest text-slate-500">GIA NHẬP CỘNG ĐỒNG VT STORE</p>
                <p class="mt-2 text-sm text-slate-600">
                    Đăng ký nhận bản tin để cập nhật mẫu mới nhất và ưu đãi độc quyền.
                </p>

                <form class="mt-6 flex items-center justify-center gap-2" method="GET" action="{{ route('products.index') }}">
                    <input
                        type="email"
                        name="newsletter"
                        placeholder="Email của bạn"
                        class="h-10 w-full max-w-sm px-3 rounded border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                    />
                    <button type="submit" class="h-10 px-5 rounded bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800">ĐĂNG KÝ</button>
                </form>
            </div>
        </section>
    </main>

    <footer class="bg-slate-900 text-slate-200">
        <div class="max-w-6xl mx-auto px-4 py-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded bg-white/10 text-white text-xs font-bold tracking-wide">VT</span>
                        <span class="font-semibold tracking-wide text-white">VT STORE</span>
                    </div>
                    <p class="mt-3 text-sm text-slate-300">
                        Điểm đến tin cậy cho cộng đồng yêu bóng đá tại Việt Nam.
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-white">SẢN PHẨM</p>
                    <ul class="mt-3 space-y-2 text-sm text-slate-300">
                        <li><a class="hover:text-white" href="{{ route('products.index') }}">Giày bóng đá</a></li>
                        <li><a class="hover:text-white" href="{{ route('products.index') }}">Áo bóng đá</a></li>
                        <li><a class="hover:text-white" href="{{ route('products.index') }}">Phụ kiện</a></li>
                    </ul>
                </div>

                <div>
                    <p class="text-sm font-semibold text-white">HỖ TRỢ</p>
                    <ul class="mt-3 space-y-2 text-sm text-slate-300">
                        <li><a class="hover:text-white" href="{{ route('orders.track.form') }}">Tra cứu đơn hàng</a></li>
                        <li><a class="hover:text-white" href="{{ route('ai-chat.index') }}">Chat AI</a></li>
                        <li><a class="hover:text-white" href="{{ route('cart.index') }}">Giỏ hàng</a></li>
                    </ul>
                </div>

                <div>
                    <p class="text-sm font-semibold text-white">ĐỊA CHỈ</p>
                    <ul class="mt-3 space-y-2 text-sm text-slate-300">
                        <li>123 Tây Sơn, TP. Hà Nội</li>
                        <li>Hotline: 1900 1234</li>
                        <li>Email: contact@vtstore.vn</li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-white/10 text-xs text-slate-400 flex items-center justify-between">
                <span>© {{ date('Y') }} VT Store. All rights reserved.</span>
                <span class="hidden sm:inline">Powered by Laravel</span>
            </div>
        </div>
    </footer>

    {{-- AI Chat Widget --}}
    <section
        id="ai-chat-widget"
        class="fixed bottom-5 right-5 z-50 w-[360px] max-w-[calc(100vw-2.5rem)] rounded-2xl border border-slate-200 bg-white shadow-lg overflow-hidden"
        aria-label="VT AI Assistant"
    >
        <header class="flex items-start justify-between gap-3 px-4 py-3 bg-slate-900 text-white">
            <div class="min-w-0">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-600 text-white text-xs font-extrabold">
                        VT
                    </span>
                    <h2 class="text-sm font-extrabold tracking-wide truncate">VT AI Assistant</h2>
                </div>
                <div class="mt-0.5 flex items-center gap-2 text-xs text-slate-200">
                    <span class="inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                    <span>Đang trực tuyến</span>
                </div>
            </div>

            <button
                id="ai-chat-close"
                type="button"
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-white/70 hover:text-white hover:bg-white/10"
                aria-label="Đóng chat"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </header>

        <div class="flex flex-col h-[520px] max-h-[70vh]">
            <div id="ai-chat-messages" class="flex-1 overflow-y-auto px-4 py-3 space-y-3 bg-white">
                {{-- messages injected by JS --}}
            </div>

            <div class="px-4 pb-2 bg-white">
                <div class="flex flex-wrap gap-2" aria-label="Gợi ý nhanh">
                    <button type="button" class="ai-chip inline-flex items-center h-7 px-3 rounded-full text-xs font-semibold border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100">
                        Tư vấn chọn size
                    </button>
                    <button type="button" class="ai-chip inline-flex items-center h-7 px-3 rounded-full text-xs font-semibold border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100">
                        Sản phẩm mới nhất
                    </button>
                    <button type="button" class="ai-chip inline-flex items-center h-7 px-3 rounded-full text-xs font-semibold border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100">
                        Chính sách đổi trả
                    </button>
                </div>
            </div>

            <div class="px-4 pb-4 bg-white">
                <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2">
                    <textarea
                        id="ai-chat-input"
                        rows="1"
                        placeholder="Nhập tin nhắn..."
                        class="flex-1 resize-none bg-transparent text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none max-h-24"
                    ></textarea>

                    <span class="inline-flex h-9 w-9 items-center justify-center text-slate-400" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l9.546-9.546a3 3 0 114.243 4.243l-9.193 9.193a1.5 1.5 0 01-2.121-2.121l8.839-8.839" />
                        </svg>
                    </span>

                    <button
                        id="ai-chat-send"
                        type="button"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-600 text-white hover:bg-emerald-500 disabled:opacity-50"
                        aria-label="Gửi"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.269 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                    </button>
                </div>

                <p id="ai-chat-error" class="mt-2 hidden text-xs text-red-600"></p>
            </div>
        </div>
    </section>

    {{-- AI Chat Launcher (shown when widget is closed) --}}
    <button
        id="ai-chat-launcher"
        type="button"
        class="fixed bottom-5 right-5 z-50 hidden h-12 w-12 items-center justify-center rounded-full bg-emerald-600 text-white shadow-lg hover:bg-emerald-500"
        aria-label="Mở VT AI Assistant"
        aria-controls="ai-chat-widget"
        aria-expanded="true"
    >
        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12c0 4.556 4.03 8.25 9 8.25.981 0 1.927-.144 2.815-.411.9.334 2.14.625 3.685.661-.539-.624-.994-1.53-1.174-2.514A7.707 7.707 0 0021.75 12c0-4.556-4.03-8.25-9-8.25s-9 3.694-9 8.25z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 12h.008v.008H8.25V12zm3.75 0h.008v.008H12V12zm3.75 0h.008v.008h-.008V12z" />
        </svg>
    </button>

    @php
        $chatWidgetInitial = ($chatMessages ?? collect())
            ->map(function ($m) {
                return [
                    'role' => (string) ($m->role ?? ''),
                    'content' => (string) ($m->content ?? ''),
                    'time' => optional($m->created_at ?? null)->format('H:i'),
                ];
            })
            ->values();
    @endphp

    <script>
        (function () {
            const widgetEl = document.getElementById('ai-chat-widget');
            const launcherEl = document.getElementById('ai-chat-launcher');
            const closeEl = document.getElementById('ai-chat-close');

            const messagesEl = document.getElementById('ai-chat-messages');
            const inputEl = document.getElementById('ai-chat-input');
            const sendBtn = document.getElementById('ai-chat-send');
            const errorEl = document.getElementById('ai-chat-error');
            const chips = Array.from(document.querySelectorAll('#ai-chat-widget .ai-chip'));

            if (!widgetEl || !launcherEl) return;

            function hideWidget() {
                widgetEl.classList.add('hidden');
                widgetEl.setAttribute('aria-hidden', 'true');

                launcherEl.classList.remove('hidden');
                launcherEl.classList.add('inline-flex');
                launcherEl.setAttribute('aria-expanded', 'false');
            }

            function showWidget() {
                widgetEl.classList.remove('hidden');
                widgetEl.setAttribute('aria-hidden', 'false');

                launcherEl.classList.add('hidden');
                launcherEl.classList.remove('inline-flex');
                launcherEl.setAttribute('aria-expanded', 'true');

                // small UX: focus input when reopening
                if (inputEl) inputEl.focus();
                if (messagesEl) messagesEl.scrollTop = messagesEl.scrollHeight;
            }

            // Ensure initial state: widget open, launcher hidden
            widgetEl.setAttribute('aria-hidden', 'false');
            launcherEl.setAttribute('aria-expanded', 'true');

            if (closeEl) closeEl.addEventListener('click', hideWidget);
            launcherEl.addEventListener('click', showWidget);

            const initial = @json($chatWidgetInitial);

            function nowTime() {
                try {
                    return new Intl.DateTimeFormat('vi-VN', { hour: '2-digit', minute: '2-digit' }).format(new Date());
                } catch (e) {
                    const d = new Date();
                    return String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
                }
            }

            function scrollToBottom() {
                messagesEl.scrollTop = messagesEl.scrollHeight;
            }

            function addMessage(role, content, time) {
                const row = document.createElement('div');
                row.className = role === 'user' ? 'flex justify-end' : 'flex justify-start';

                const wrap = document.createElement('div');
                wrap.className = 'max-w-[85%]';

                const bubbleRow = document.createElement('div');
                bubbleRow.className = 'flex items-end gap-2 ' + (role === 'user' ? 'justify-end' : 'justify-start');

                if (role !== 'user') {
                    const avatar = document.createElement('div');
                    avatar.className = 'shrink-0 inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-600 text-white text-[10px] font-extrabold';
                    avatar.textContent = 'VT';
                    bubbleRow.appendChild(avatar);
                }

                const bubble = document.createElement('div');
                bubble.className = role === 'user'
                    ? 'rounded-2xl rounded-br-md bg-slate-900 text-white px-3 py-2 text-sm leading-relaxed'
                    : 'rounded-2xl rounded-bl-md bg-white border border-slate-200 text-slate-900 px-3 py-2 text-sm leading-relaxed';
                bubble.textContent = content;
                bubbleRow.appendChild(bubble);

                wrap.appendChild(bubbleRow);

                const meta = document.createElement('div');
                meta.className = 'mt-1 text-[10px] text-slate-400 ' + (role === 'user' ? 'text-right' : 'pl-9');
                meta.textContent = time || '';
                wrap.appendChild(meta);

                row.appendChild(wrap);
                messagesEl.appendChild(row);
                scrollToBottom();
            }

            function showError(msg) {
                errorEl.textContent = msg;
                errorEl.classList.remove('hidden');
                setTimeout(() => errorEl.classList.add('hidden'), 5000);
            }

            function autoResize() {
                inputEl.style.height = 'auto';
                inputEl.style.height = Math.min(inputEl.scrollHeight, 96) + 'px';
            }

            async function submit(text) {
                text = (text || '').trim();
                if (!text) return;

                errorEl.classList.add('hidden');
                addMessage('user', text, nowTime());
                inputEl.value = '';
                autoResize();
                sendBtn.disabled = true;

                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const res = await fetch(@json(route('ai-chat.message')), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || '',
                        },
                        body: JSON.stringify({ message: text }),
                    });

                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) throw new Error(data?.message || 'Không gửi được tin nhắn');
                    addMessage('assistant', String(data.reply || ''), nowTime());
                } catch (err) {
                    showError(err?.message || 'Có lỗi xảy ra.');
                } finally {
                    sendBtn.disabled = false;
                    inputEl.focus();
                }
            }

            // Initial render
            if (Array.isArray(initial) && initial.length) {
                initial.forEach(m => addMessage(m.role === 'user' ? 'user' : 'assistant', String(m.content || ''), String(m.time || '')));
            } else {
                addMessage('assistant', 'Chào mừng bạn đến với VT Store! Tôi có thể giúp gì cho bạn hôm nay?', nowTime());
            }

            // Events
            chips.forEach(btn => btn.addEventListener('click', () => submit(btn.textContent)));
            inputEl.addEventListener('input', autoResize);
            inputEl.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    submit(inputEl.value);
                }
            });
            sendBtn.addEventListener('click', () => submit(inputEl.value));

            autoResize();
            scrollToBottom();
        })();
    </script>

</body>
</html>
