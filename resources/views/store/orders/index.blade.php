<x-store-layout title="Đơn hàng - {{ config('app.name', 'VT Store') }}" :search-action="route('products.index')">
    <x-slot name="headerSearchHidden">
        @if ($status)
            <input type="hidden" name="status" value="{{ $status }}" />
        @endif
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 py-8">
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
    </div>

</x-store-layout>