@props([
    'searchAction' => null,
    'searchValue' => null,
    'showSearch' => true,
])

@php
    $cartCount = \App\Support\Cart::count();
    $searchAction = $searchAction ?? route('products.index');
    $searchValue = $searchValue ?? (string) request('q', '');

    $type = (string) request('type', '');
    $category = request('category');

    $activeShoes = $type === 'giay';
    $activeJersey = $type === 'ao_dau';
    $activeAccessory = $category === 'phu-kien' || (is_array($category) && in_array('phu-kien', $category, true));
@endphp

<header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-4">
        <div class="h-16 flex items-center gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                <span class="inline-flex h-7 w-7 items-center justify-center rounded bg-slate-900 text-white text-xs font-bold tracking-wide">VT</span>
                <span class="font-semibold tracking-wide">VT STORE</span>
            </a>

            <nav class="hidden md:flex items-center gap-6 text-xs font-semibold tracking-wide uppercase text-slate-700">
                <a class="hover:text-slate-900 {{ $activeShoes ? 'text-slate-900' : '' }}" href="{{ route('products.index', ['type' => 'giay']) }}">Giày bóng đá</a>
                <a class="hover:text-slate-900 {{ $activeJersey ? 'text-slate-900' : '' }}" href="{{ route('products.index', ['type' => 'ao_dau']) }}">Áo bóng đá</a>
                <a class="hover:text-slate-900 {{ $activeAccessory ? 'text-slate-900' : '' }}" href="{{ route('products.index', ['category' => 'phu-kien']) }}">Phụ kiện</a>
                <a
                    class="hover:text-slate-900"
                    href="{{ route('ai-chat.index') }}"
                    onclick="if (window.VT_AI_CHAT_WIDGET && typeof window.VT_AI_CHAT_WIDGET.open === 'function') { window.VT_AI_CHAT_WIDGET.open(); return false; }"
                >
                    Chat AI
                </a>
            </nav>

            @if ($showSearch)
                <form class="flex-1 flex justify-center" method="GET" action="{{ $searchAction }}">
                    {{ $slot }}
                    <div class="w-full max-w-lg relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <input
                            name="q"
                            value="{{ $searchValue }}"
                            placeholder="Tìm kiếm sản phẩm..."
                            class="w-full h-10 pl-9 pr-3 rounded-full border border-slate-200 bg-slate-100 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                        />
                    </div>
                </form>
            @else
                <div class="flex-1"></div>
            @endif

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
                    <a href="{{ route('orders.index') }}" class="hidden md:inline text-sm text-slate-700 hover:text-slate-900">Đơn hàng</a>
                @else
                    <a href="{{ route('orders.track.form') }}" class="hidden md:inline text-sm text-slate-700 hover:text-slate-900">Tra cứu đơn</a>
                @endauth

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
