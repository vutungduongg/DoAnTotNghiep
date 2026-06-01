@php
        $status = (string) ($order->status ?? '');

        $isCancelled = $status === \App\Models\Order::STATUS_CANCELLED;
        $isDelivered = $status === \App\Models\Order::STATUS_DELIVERED;
        $isShipping = $status === \App\Models\Order::STATUS_SHIPPING;
        $isPending = $status === \App\Models\Order::STATUS_PENDING;

        // Steps: 1=Đã đặt, 2=Đang xử lý, 3=Đang giao, 4=Hoàn thành
        $currentStep = 2;
        if ($isShipping) $currentStep = 3;
        if ($isDelivered) $currentStep = 4;
        if ($isCancelled) $currentStep = 1;

        $createdDate = $order->created_at ? $order->created_at->format('d/m/Y') : '';
        $paymentText = $isDelivered ? 'Đã thanh toán' : 'Chưa thanh toán';
@endphp

<x-store-layout title="Chi tiết đơn hàng - {{ config('app.name', 'VT Store') }}" :search-action="route('products.index')">
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight">CHI TIẾT ĐƠN HÀNG <span class="font-mono">{{ $order->order_number }}</span></h1>
                <div class="mt-1 text-sm text-slate-600">Ngày đặt hàng: {{ $createdDate }}</div>
            </div>

            <div class="flex flex-wrap gap-3">
                @if ($isGuest)
                    <a href="{{ route('orders.track.form') }}" class="inline-flex items-center justify-center h-10 px-4 rounded-xl border border-slate-300 text-slate-900 text-sm font-semibold hover:bg-white">
                        ← Quay lại tra cứu
                    </a>
                @else
                    <a href="{{ route('orders.index') }}" class="inline-flex items-center justify-center h-10 px-4 rounded-xl border border-slate-300 text-slate-900 text-sm font-semibold hover:bg-white">
                        ← Quay lại đơn hàng của tôi
                    </a>
                @endif

                <a href="{{ route('orders.track.form') }}" class="inline-flex items-center justify-center h-10 px-4 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-500">
                    Liên hệ hỗ trợ
                </a>
            </div>
        </div>

        @if ($isGuest)
            <div class="mt-5 bg-emerald-50 border border-emerald-200 rounded-2xl px-5 py-4 text-sm text-emerald-900">
                Bạn đang xem đơn hàng theo chế độ tra cứu.
            </div>
        @endif

        @if ($isCancelled)
            <div class="mt-5 bg-red-50 border border-red-200 rounded-2xl px-5 py-4 text-sm text-red-800">
                Đơn hàng đã bị hủy.
            </div>
        @endif

        <section class="mt-6 bg-white border border-slate-200 rounded-2xl p-6">
            <h2 class="text-base font-extrabold">Trạng thái đơn hàng</h2>
            <div class="mt-5">
                <div class="relative">
                    <div class="absolute left-0 right-0 top-5 h-1 rounded bg-slate-200"></div>
                    <div class="absolute left-0 top-5 h-1 rounded bg-emerald-600" style="width: {{ $currentStep <= 1 ? 0 : ($currentStep === 2 ? 33 : ($currentStep === 3 ? 66 : 100)) }}%;"></div>

                    <div class="grid grid-cols-4 gap-2">
                        @foreach ([
                            1 => ['label' => 'Đã đặt', 'icon' => 'check'],
                            2 => ['label' => 'Đang xử lý', 'icon' => 'bolt'],
                            3 => ['label' => 'Đang giao', 'icon' => 'truck'],
                            4 => ['label' => 'Hoàn thành', 'icon' => 'flag'],
                        ] as $step => $meta)
                            @php
                                $done = $currentStep > $step;
                                $active = $currentStep === $step;
                                $nodeClass = ($done || $active) ? 'bg-emerald-600 text-white' : 'bg-white text-slate-400 border border-slate-200';
                            @endphp
                            <div class="text-center">
                                <div class="mx-auto h-10 w-10 rounded-xl flex items-center justify-center {{ $nodeClass }}">
                                    @if ($meta['icon'] === 'check')
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8 10L4 11"/></svg>
                                    @elseif ($meta['icon'] === 'bolt')
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    @elseif ($meta['icon'] === 'truck')
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 01-3 0m3 0h9.75m-9.75 0H5.25m14.25 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 01-3 0m3 0h.75a.75.75 0 00.75-.75V14.25m-1.5 4.5h-3.75M3 13.5V6.75A.75.75 0 013.75 6h11.5a.75.75 0 01.75.75v11.25m0-4.5h4.5m0 0l-1.5-3.75A1.5 1.5 0 0017.1 9H15.75"/></svg>
                                    @else
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M5 7h4M19 3v4m0 0h-4m4 0V3M7 21h10a2 2 0 002-2V9a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    @endif
                                </div>
                                <div class="mt-2 text-xs font-semibold {{ ($done || $active) ? 'text-emerald-700' : 'text-slate-500' }}">{{ $meta['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <div class="mt-6 grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <section class="lg:col-span-8">
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h2 class="text-base font-extrabold">Sản phẩm đã chọn</h2>
                    </div>

                    <div class="hidden md:grid grid-cols-12 gap-3 px-6 py-3 border-b border-slate-200 text-xs font-semibold tracking-wide uppercase text-slate-500">
                        <div class="col-span-6">Sản phẩm</div>
                        <div class="col-span-2">Số lượng</div>
                        <div class="col-span-2">Giá</div>
                        <div class="col-span-2 text-right">Thành tiền</div>
                    </div>

                    @foreach ($order->items as $it)
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 px-6 py-5 border-b border-slate-200 items-center">
                            <div class="md:col-span-6 flex items-center gap-4">
                                <div class="h-16 w-16 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0">
                                    @if ($it->product?->image_path)
                                        <img src="{{ asset('storage/' . $it->product->image_path) }}" alt="{{ $it->product_name }}" class="h-full w-full object-contain" />
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-slate-400">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3 3h18v18H3V3z" /></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-slate-900 leading-snug">{{ $it->product_name }}</div>
                                    <div class="mt-1 text-xs text-slate-500">Size: {{ $it->size ?: '-' }}</div>
                                </div>
                            </div>

                            <div class="md:col-span-2 text-sm text-slate-700">{{ (int) $it->quantity }}</div>
                            <div class="md:col-span-2 text-sm font-semibold text-slate-900">{{ number_format((float) $it->unit_price, 0, ',', '.') }}đ</div>
                            <div class="md:col-span-2 text-sm font-extrabold text-slate-900 md:text-right">{{ number_format((float) $it->line_total, 0, ',', '.') }}đ</div>
                        </div>
                    @endforeach
                </div>

                @if ($order->note)
                    <div class="mt-6 bg-white border border-slate-200 rounded-2xl p-6">
                        <h3 class="text-sm font-extrabold">Ghi chú</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-7 whitespace-pre-line">{{ $order->note }}</p>
                    </div>
                @endif
            </section>

            <aside class="lg:col-span-4">
                <div class="bg-slate-900 text-white rounded-2xl p-6 sticky top-24">
                    <h2 class="text-lg font-extrabold">Tổng kết đơn hàng</h2>

                    <div class="mt-5 space-y-2 text-sm text-slate-200">
                        <div class="flex items-center justify-between">
                            <span>Tạm tính</span>
                            <span class="font-semibold text-white">{{ number_format((float) $order->subtotal, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Phí vận chuyển</span>
                            <span class="font-semibold">{{ number_format((float) $order->shipping_fee, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Giảm giá</span>
                            <span class="font-semibold">0đ</span>
                        </div>
                    </div>

                    <div class="mt-5 pt-5 border-t border-white/10 flex items-end justify-between">
                        <span class="text-slate-200">Tổng cộng</span>
                        <span class="text-2xl font-extrabold text-emerald-300">{{ number_format((float) $order->total, 0, ',', '.') }}đ</span>
                    </div>

                    <div class="mt-5 rounded-xl bg-white/5 border border-white/10 px-4 py-3 text-xs text-slate-200">
                        Dự kiến giao hàng trong 2–4 ngày làm việc.
                    </div>

                    <a href="{{ route('orders.track.form') }}" class="mt-5 inline-flex items-center justify-center w-full h-12 rounded-xl bg-emerald-600 text-white text-sm font-extrabold tracking-wide hover:bg-emerald-500">
                        THEO DÕI KIỆN HÀNG
                    </a>
                </div>
            </aside>
        </div>

        <section class="mt-6 grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-6 bg-white border border-slate-200 rounded-2xl p-6">
                <h3 class="text-sm font-extrabold">Địa chỉ nhận hàng</h3>
                <div class="mt-3 text-sm text-slate-700">
                    <div class="font-semibold">{{ $order->customer_name }}</div>
                    <div class="mt-1 text-slate-600">{{ $order->customer_phone }}</div>
                    <div class="mt-1 text-slate-600">{{ $order->shipping_address }}</div>
                </div>
            </div>

            <div class="lg:col-span-6 bg-white border border-slate-200 rounded-2xl p-6">
                <h3 class="text-sm font-extrabold">Thanh toán</h3>
                <div class="mt-3 text-sm text-slate-700 space-y-2">
                    <div>Phương thức: <span class="font-semibold">Thanh toán khi nhận hàng (COD)</span></div>
                    <div>Trạng thái: <span class="font-semibold {{ $paymentText === 'Đã thanh toán' ? 'text-emerald-700' : 'text-red-600' }}">{{ $paymentText }}</span></div>
                    <div class="inline-flex items-center h-6 px-2 rounded bg-emerald-50 text-emerald-700 text-xs font-semibold">Ưu đãi: Miễn phí vận chuyển</div>
                </div>
            </div>
        </section>
    </div>

</x-store-layout>