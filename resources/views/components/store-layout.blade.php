<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="background:#030712;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? config('app.name', 'VT Store') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="background:#030712; color:#f3f4f6;">

        {{-- NAVBAR --}}
        <nav class="sticky top-0 z-50" style="background:#111827; border-bottom:1px solid #1f2937;">
            <div class="px-6">
                <div class="flex justify-between items-center h-16">

                    {{-- Left --}}
                    <div class="flex items-center" style="gap:48px;">
                        <a href="{{ route('products.index') }}" class="flex items-center shrink-0" style="gap:10px;">
                            <img src="{{ asset('storage/images/sport.png') }}" class="w-6 h-6 object-contain shrink-0" style="color:#fbbf24;" />
                            <span class="font-semibold text-sm tracking-wide" style="color:#fff; white-space:nowrap;">
                                {{ config('app.name', 'VT Store') }}
                            </span>
                        </a>

                        <div class="hidden sm:flex items-center" style="gap:32px;">
                            <a href="{{ route('products.index') }}"
                            class="text-sm transition-colors hover:text-white" style="color:#9ca3af; white-space:nowrap;">
                                Sản phẩm
                            </a>
                            <a href="{{ route('orders.track.form') }}"
                            class="text-sm transition-colors hover:text-white" style="color:#9ca3af; white-space:nowrap;">
                                Tra cứu đơn
                            </a>
                            @auth
                                <a href="{{ route('orders.index') }}"
                                class="text-sm transition-colors hover:text-white" style="color:#9ca3af; white-space:nowrap;">
                                    Đơn hàng
                                </a>
                            @endauth
                        </div>
                    </div>

                    {{-- Right --}}
                    <div class="flex items-center gap-4">
                        <a href="{{ route('cart.index') }}"
                           class="flex items-center gap-1.5 text-sm transition-colors hover:text-amber-400"
                           style="color:#9ca3af;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                            </svg>
                            <span class="font-medium">{{ \App\Support\Cart::count() }}</span>
                        </a>

                        @auth
                            <a href="{{ route('profile.edit') }}"
                               class="text-sm transition-colors hover:text-white" style="color:#9ca3af;">
                                Tài khoản
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="text-sm transition-colors hover:text-white" style="color:#9ca3af;">
                                    Đăng xuất
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                               class="text-sm transition-colors hover:text-white" style="color:#9ca3af;">
                                Đăng nhập
                            </a>
                            <a href="{{ route('register') }}"
                               class="px-3 py-1.5 text-sm font-semibold rounded-lg transition-colors"
                               style="background:#fbbf24; color:#111827;">
                                Đăng ký
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        @if (session('status'))
            <div class="mx-6 mt-4 px-4 py-3 rounded-lg text-sm"
                 style="background:rgba(20,83,45,0.5); border:1px solid #166534; color:#86efac;">
                {{ session('status') }}
            </div>
        @endif

        <main>{{ $slot }}</main>

    </body>
</html>