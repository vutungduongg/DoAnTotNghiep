<x-store-layout :title="config('app.name', 'VT Store')">
        <section class="bg-slate-900 text-white">
            <div class="max-w-6xl mx-auto px-4">
                <div class="py-10 md:py-14 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                    <div>
                        <span class="inline-flex items-center h-6 px-2 rounded bg-emerald-600/20 text-emerald-200 text-xs font-semibold">BỘ SƯU TẬP MỚI 2024</span>
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
                            <a href="{{ route('products.index') }}" class="relative block h-full w-full" aria-label="Xem sản phẩm">
                                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 via-slate-900 to-blue-500/10"></div>
                                <img
                                    src="{{ asset('storage/images/BG.jpg') }}"
                                    alt="Sản phẩm VT Store"
                                    class="absolute inset-0 h-full w-full object-cover object-center"
                                    loading="lazy"
                                />
                            </a>
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

                <form class="mt-6 flex items-center justify-center gap-2" method="GET" action="{{ route('register') }}">
                    <input
                        type="email"
                        placeholder="Email của bạn"
                        class="h-10 w-full max-w-sm px-3 rounded border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                    />
                    <button type="submit" class="h-10 px-5 rounded bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800">ĐĂNG KÝ</button>
                </form>
            </div>
        </section>

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
                        <li>
                            <a
                                class="hover:text-white"
                                href="{{ route('ai-chat.index') }}"
                                onclick="if (window.VT_AI_CHAT_WIDGET && typeof window.VT_AI_CHAT_WIDGET.open === 'function') { window.VT_AI_CHAT_WIDGET.open(); return false; }"
                            >
                                Chat AI
                            </a>
                        </li>
                        <li><a class="hover:text-white" href="{{ route('orders.index') }}">Đơn hàng</a></li>
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
                <span>© {{ date('Y') }} VT Store. Bản quyền thuộc về VT Store.</span>
            </div>
        </div>
    </footer>

</x-store-layout>
