<x-store-layout title="Đặt hàng thành công - {{ config('app.name', 'VT Store') }}">
    <div class="max-w-6xl mx-auto px-4 py-12">
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
    </div>

</x-store-layout>