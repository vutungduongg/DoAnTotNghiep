<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} - {{ config('app.name', 'VT Store') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">

    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <aside class="w-72 shrink-0 bg-slate-950 text-slate-100 flex flex-col">
            <div class="px-6 py-6">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-emerald-500/15 flex items-center justify-center border border-emerald-500/25">
                        <span class="text-emerald-300 font-bold">V</span>
                    </div>
                    <div>
                        <div class="text-sm font-semibold tracking-wide">VT STORE</div>
                        <div class="text-xs text-slate-400">Quản trị viên</div>
                    </div>
                </div>
            </div>

            @php
                $navItem = function (string $route, string $label, string $icon) {
                    $active = request()->routeIs($route);
                    return [
                        'href' => route($route),
                        'label' => $label,
                        'active' => $active,
                        'icon' => $icon,
                    ];
                };

                $items = [
                    $navItem('admin.dashboard', 'Bảng điều khiển', 'grid'),
                    $navItem('admin.categories.index', 'Quản lý danh mục', 'tag'),
                    $navItem('admin.products.index', 'Quản lý sản phẩm', 'box'),
                    $navItem('admin.orders.index', 'Quản lý đơn hàng', 'clipboard'),
                ];
            @endphp

            <nav class="px-4">
                <div class="space-y-1">
                    @foreach($items as $it)
                        <a href="{{ $it['href'] }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors {{ $it['active'] ? 'bg-emerald-500/15 text-emerald-200' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                            @if($it['icon'] === 'grid')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75h7.5v7.5h-7.5v-7.5zm9 0h7.5v7.5h-7.5v-7.5zm-9 9h7.5v7.5h-7.5v-7.5zm9 0h7.5v7.5h-7.5v-7.5z"/></svg>
                            @elseif($it['icon'] === 'tag')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3.75H5.25A1.5 1.5 0 003.75 5.25v4.318a1.5 1.5 0 00.44 1.06l8.88 8.88a1.5 1.5 0 002.12 0l4.318-4.318a1.5 1.5 0 000-2.12l-8.88-8.88a1.5 1.5 0 00-1.06-.44z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.008v.008H6.75V6.75z"/></svg>
                            @elseif($it['icon'] === 'box')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9 5.25L3 7.5m18 0l-9-5.25L3 7.5m18 0v9A2.25 2.25 0 0118.75 18.75H5.25A2.25 2.25 0 013 16.5v-9m18 0l-9 5.25L3 7.5"/></svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 3h6m-6-6h6M7.5 3.75h9A2.25 2.25 0 0118.75 6v15a2.25 2.25 0 01-2.25 2.25h-9A2.25 2.25 0 015.25 21V6A2.25 2.25 0 017.5 3.75z"/></svg>
                            @endif
                            <span class="font-medium">{{ $it['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </nav>

            <div class="mt-auto p-4 space-y-3">
                <a href="{{ route('admin.products.create') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-lg text-sm font-semibold bg-emerald-500 text-white hover:bg-emerald-600 transition-colors">
                    <span class="text-lg leading-none">+</span>
                    Thêm sản phẩm mới
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-lg text-sm font-semibold bg-white/5 text-slate-200 hover:bg-white/10 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 9l3 3m0 0l-3 3m3-3H8.25"/></svg>
                        Đăng xuất
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 min-w-0">
            <header class="h-16 bg-white border-b border-gray-200 px-6 flex items-center justify-between gap-4">
                <div class="flex-1 max-w-xl">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        <input placeholder="Tìm kiếm hệ thống..." class="w-full pl-10 pr-4 py-2 rounded-lg text-sm bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" class="w-10 h-10 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 flex items-center justify-center text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0018 9.75v-.7V9A6 6 0 006 9v.05-.05v.7a8.967 8.967 0 00-2.31 6.022 23.848 23.848 0 005.455 1.31m5.712 0a3 3 0 11-5.712 0m5.712 0a24.255 24.255 0 01-5.712 0"/></svg>
                    </button>
                    <button type="button" class="w-10 h-10 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 flex items-center justify-center text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0115 0v.75a2.25 2.25 0 002.25 2.25H2.25A2.25 2.25 0 004.5 12.75V12z"/><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6.75h3"/></svg>
                    </button>

                    <div class="h-8 w-px bg-gray-200"></div>

                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <div class="text-sm font-semibold text-gray-900">{{ auth()->user()->name ?? 'Admin' }}</div>
                            <div class="text-xs text-gray-500">Admin {{ config('app.name', 'VT Store') }}</div>
                        </div>
                        <div class="w-9 h-9 rounded-full overflow-hidden bg-gray-200 shrink-0">
                            @php($avatar = auth()->user()->google_avatar ?? null)
                            @if($avatar)
                                <img src="{{ $avatar }}" alt="Avatar" class="w-full h-full object-cover" />
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            @if (session('status'))
                <div class="px-6 pt-4">
                    <div class="px-4 py-3 rounded-lg text-sm bg-emerald-50 border border-emerald-200 text-emerald-700">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            <main class="px-6 py-6">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
