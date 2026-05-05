@extends('admin.layout', ['title' => 'Bảng điều khiển'])

@section('content')
    @php
        $fmtMoney = fn ($v) => number_format((float) $v, 0, ',', '.').'đ';

        $badgeClass = function ($status) {
            return match ($status) {
                \App\Models\Order::STATUS_DELIVERED => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                \App\Models\Order::STATUS_SHIPPING  => 'bg-sky-50 text-sky-700 border border-sky-200',
                \App\Models\Order::STATUS_CANCELLED => 'bg-rose-50 text-rose-700 border border-rose-200',
                default                             => 'bg-amber-50 text-amber-700 border border-amber-200',
            };
        };

        $cards = [
            [
                'label'     => 'TỔNG DOANH THU',
                'value'     => $fmtMoney($revenueTotal ?? 0),
                'change'    => '+12.5%',
                'color'     => 'emerald',
                'icon'      => 'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75',
            ],
            [
                'label'     => 'TỔNG ĐƠN HÀNG',
                'value'     => number_format((int)($ordersCount ?? 0)),
                'change'    => '+8.2%',
                'color'     => 'sky',
                'icon'      => 'M9 12h6m-6 3h6m-6-6h6M7.5 3.75h9A2.25 2.25 0 0118.75 6v15a2.25 2.25 0 01-2.25 2.25h-9A2.25 2.25 0 015.25 21V6A2.25 2.25 0 017.5 3.75z',
            ],
            [
                'label'     => 'TỔNG KHÁCH HÀNG',
                'value'     => number_format((int)($customersCount ?? 0)),
                'change'    => '+5.4%',
                'color'     => 'violet',
                'icon'      => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766v-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
            ],
            [
                'label'     => 'TỔNG SẢN PHẨM',
                'value'     => number_format((int)($productsCount ?? 0)),
                'change'    => 'Mới',
                'color'     => 'amber',
                'icon'      => 'M21 7.5l-9 5.25L3 7.5m18 0l-9-5.25L3 7.5m18 0v9A2.25 2.25 0 0118.75 18.75H5.25A2.25 2.25 0 013 16.5v-9',
            ],
        ];

        $theme = [
            'emerald' => ['icon' => 'bg-emerald-50 border-emerald-100 text-emerald-600', 'badge' => 'bg-emerald-50 text-emerald-600'],
            'sky'     => ['icon' => 'bg-sky-50 border-sky-100 text-sky-600',             'badge' => 'bg-sky-50 text-sky-600'],
            'violet'  => ['icon' => 'bg-violet-50 border-violet-100 text-violet-600',    'badge' => 'bg-violet-50 text-violet-600'],
            'amber'   => ['icon' => 'bg-amber-50 border-amber-100 text-amber-700',       'badge' => 'bg-amber-50 text-amber-700'],
        ];

        $barColors = ['bg-emerald-400', 'bg-sky-400', 'bg-violet-400'];
    @endphp

    <div class="max-w-6xl mx-auto">

        {{-- ── Header ── --}}
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Tổng quan hệ thống</h1>
                <p class="text-sm mt-1 text-gray-500">Chào mừng trở lại, đây là những gì đang diễn ra hôm nay.</p>
            </div>
            <div class="hidden sm:flex items-center gap-2 px-3 py-2 rounded-lg bg-white border border-gray-200 text-sm text-gray-600 shrink-0">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25m10.5-2.25V5.25M3.75 8.25h16.5M4.5 6.75h15A1.5 1.5 0 0121 8.25v12A1.5 1.5 0 0119.5 21h-15A1.5 1.5 0 013 20.25v-12A1.5 1.5 0 014.5 6.75z"/>
                </svg>
                <span>{{ now()->isoFormat('dddd, D [Tháng] M, Y') }}</span>
            </div>
        </div>

        {{-- ── Stat Cards ── --}}
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($cards as $card)
                @php $t = $theme[$card['color']]; @endphp
                <div class="relative p-5 rounded-xl bg-white border border-gray-200 overflow-hidden">
                    <span class="absolute top-4 right-4 text-xs font-semibold px-2 py-0.5 rounded-full {{ $t['badge'] }}">
                        {{ $card['change'] }}
                    </span>
                    <div class="w-11 h-11 rounded-xl border flex items-center justify-center {{ $t['icon'] }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                        </svg>
                    </div>
                    <div class="mt-4">
                        <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">{{ $card['label'] }}</div>
                        <div class="mt-1.5 text-2xl font-semibold text-gray-900 tracking-tight">{{ $card['value'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ── Main Grid ── --}}
        <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">

            {{-- Recent orders --}}
            <div class="lg:col-span-2 rounded-xl bg-white border border-gray-200 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                    <span class="text-sm font-semibold text-gray-900">Đơn hàng gần đây</span>
                    <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                        Xem tất cả →
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/60">
                                <th class="text-left text-[11px] font-semibold text-gray-400 uppercase tracking-widest px-5 py-3">Mã đơn</th>
                                <th class="text-left text-[11px] font-semibold text-gray-400 uppercase tracking-widest px-3 py-3">Khách hàng</th>
                                <th class="text-left text-[11px] font-semibold text-gray-400 uppercase tracking-widest px-3 py-3">Tổng tiền</th>
                                <th class="text-left text-[11px] font-semibold text-gray-400 uppercase tracking-widest px-3 py-3">Trạng thái</th>
                                <th class="text-left text-[11px] font-semibold text-gray-400 uppercase tracking-widest px-3 py-3">Ngày đặt</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recentOrders as $o)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-5 py-3.5 font-semibold text-gray-900 whitespace-nowrap">{{ $o->order_number }}</td>
                                    <td class="px-3 py-3.5">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-[10px] font-semibold text-gray-500 shrink-0 select-none">
                                                {{ mb_strtoupper(mb_substr($o->customer_name, 0, 1)) }}
                                            </div>
                                            <span class="text-gray-700 whitespace-nowrap">{{ $o->customer_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3.5 text-gray-700 font-medium whitespace-nowrap">{{ $fmtMoney($o->total) }}</td>
                                    <td class="px-3 py-3.5 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $badgeClass($o->status) }}">
                                            {{ $o->status }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3.5 text-gray-500 whitespace-nowrap">{{ optional($o->created_at)->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Right sidebar --}}
            <div class="space-y-4">

                {{-- Top products --}}
                <div class="rounded-xl bg-slate-900 overflow-hidden">
                    <div class="flex items-center justify-between px-5 pt-5 pb-2">
                        <div class="flex items-center gap-2 text-sm font-semibold text-white">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/>
                            </svg>
                            Sản phẩm bán chạy
                        </div>
                        <span class="text-[11px] text-slate-400 font-medium">Top 3</span>
                    </div>

                    <div class="px-5 pb-5 mt-3 space-y-4">
                        @foreach($topProducts as $i => $tp)
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-slate-800 border border-slate-700 overflow-hidden shrink-0 flex items-center justify-center">
                                    @if(!empty($tp['image']))
                                        <img src="{{ $tp['image'] }}" alt="{{ $tp['name'] }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9 5.25L3 7.5m18 0l-9-5.25L3 7.5m18 0v9A2.25 2.25 0 0118.75 18.75H5.25A2.25 2.25 0 013 16.5v-9"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-sm font-semibold text-white truncate pr-2">{{ $tp['name'] }}</span>
                                        <span class="text-xs text-slate-300 shrink-0">{{ $tp['percent'] }}%</span>
                                    </div>
                                    <div class="h-1.5 rounded-full bg-white/10 overflow-hidden">
                                        <div class="h-1.5 rounded-full {{ $barColors[$i] ?? 'bg-emerald-400' }}" style="width: {{ $tp['percent'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Campaign --}}
                <div class="relative rounded-xl overflow-hidden bg-emerald-500 text-white p-5">
                    <svg class="absolute right-3 top-3 opacity-20 pointer-events-none" width="60" height="60" viewBox="0 0 64 64" fill="none">
                        <path d="M32 4L35 28L60 32L35 36L32 60L29 36L4 32L29 28Z" fill="white"/>
                    </svg>
                    <svg class="absolute right-14 bottom-5 opacity-10 pointer-events-none" width="26" height="26" viewBox="0 0 28 28" fill="none">
                        <path d="M14 2L16 12L26 14L16 16L14 26L12 16L2 14L12 12Z" fill="white"/>
                    </svg>
                    <div class="relative">
                        <div class="text-[11px] font-bold uppercase tracking-widest text-emerald-50/80">Chiến dịch mùa hè</div>
                        <div class="mt-2 text-sm leading-relaxed text-emerald-50/90">
                            Chỉ còn 3 ngày để kết thúc khuyến mãi giảm giá 20% cho danh mục giày bóng đá.
                        </div>
                        <a href="{{ route('admin.categories.index') }}"
                           class="inline-flex items-center mt-4 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide bg-slate-900 text-white hover:bg-slate-800 transition-colors">
                            Kiểm tra ngay
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection