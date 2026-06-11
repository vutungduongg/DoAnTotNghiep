<x-store-layout title="Giỏ hàng - {{ config('app.name', 'VT Store') }}">

    @if (session('status'))
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="px-4 py-3 rounded-xl text-sm bg-emerald-50 border border-emerald-200 text-emerald-900">
                {{ session('status') }}
            </div>
        </div>
    @endif

    @if (isset($canCheckout) && !$canCheckout)
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="px-4 py-3 rounded-xl text-sm bg-rose-50 border border-rose-200 text-rose-900">
                Có sản phẩm đã hết hàng hoặc vượt tồn kho. Vui lòng cập nhật giỏ hàng để tiếp tục đặt hàng.
            </div>
        </div>
    @endif

    <div class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-extrabold tracking-tight">GIỎ HÀNG CỦA BẠN</h1>

        @if ($items === [])
            <div class="mt-6 bg-white border border-slate-200 rounded-2xl p-10 text-center">
                <p class="text-slate-600">Giỏ hàng đang trống.</p>
                <a href="{{ route('products.index') }}" class="mt-5 inline-flex items-center h-10 px-5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800">
                    Xem sản phẩm
                </a>
            </div>
        @else
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                <section class="lg:col-span-8">
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                        <div class="hidden md:grid grid-cols-12 gap-3 px-6 py-4 border-b border-slate-200 text-xs font-semibold tracking-wide uppercase text-slate-500">
                            <div class="col-span-6">Sản phẩm</div>
                            <div class="col-span-2">Giá</div>
                            <div class="col-span-2">Số lượng</div>
                            <div class="col-span-2 text-right whitespace-nowrap">Thành tiền</div>
                        </div>

                        @foreach ($items as $key => $item)
                            @php $line = (float) $item['price'] * (int) $item['quantity']; @endphp
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 px-6 py-5 border-b border-slate-200 items-center">
                                <div class="md:col-span-6 flex items-center gap-4">
                                    <div class="h-20 w-20 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0">
                                        @if (!empty($item['image_path']))
                                            <img src="{{ asset('storage/' . $item['image_path']) }}" alt="{{ $item['name'] }}" class="h-full w-full object-contain" />
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-slate-400">
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3 3h18v18H3V3z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="min-w-0 space-y-2">
                                        @php
                                            $nameLines = preg_split("/\r\n|\r|\n/u", (string) ($item['name'] ?? '')) ?: [];
                                            $nameLines = array_values(array_filter(array_map('trim', $nameLines), fn ($v) => $v !== ''));
                                        @endphp

                                        <div class="text-sm font-semibold text-slate-900 leading-relaxed break-words">
                                            {{ $nameLines[0] ?? (string) ($item['name'] ?? '') }}
                                        </div>

                                        @if (count($nameLines) > 1)
                                            <div class="space-y-1">
                                                @foreach (array_slice($nameLines, 1) as $line)
                                                    <div class="text-xs font-medium text-slate-700 leading-relaxed break-words">{{ $line }}</div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="text-xs text-slate-500 leading-relaxed">
                                            @if (!empty($item['size']))
                                                Kích cỡ: <span class="font-semibold text-slate-700">{{ $item['size'] }}</span>
                                            @else
                                                Kích cỡ: <span class="font-semibold text-slate-700">-</span>
                                            @endif
                                        </div>

                                        @if (!empty($item['variant_id']))
                                            @if (!empty($item['is_out_of_stock']))
                                                <div class="text-xs font-semibold text-rose-600">Hết hàng</div>
                                            @elseif (!empty($item['is_low_stock']))
                                                <div class="text-xs font-semibold text-amber-700">Sắp hết hàng (còn {{ (int) ($item['stock'] ?? 0) }})</div>
                                            @endif

                                            @if (!empty($item['stock_error']))
                                                <div class="text-xs font-semibold text-rose-600">{{ $item['stock_error'] }}</div>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                <div class="md:col-span-2 text-sm text-slate-700 font-semibold">
                                    {{ number_format((float) $item['price'], 0, ',', '.') }}đ
                                </div>

                                <div class="md:col-span-2 md:flex md:justify-center" x-data="{ quantity: {{ (int) $item['quantity'] }} }">
                                    <form method="POST" action="{{ route('cart.update', ['key' => $key]) }}" class="inline-flex items-center rounded-lg border border-slate-200 bg-white overflow-hidden">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            type="button"
                                            class="h-9 w-9 inline-flex items-center justify-center text-slate-700 hover:bg-slate-50"
                                            x-on:click.prevent="
                                                if (quantity > 0) {
                                                    quantity--;
                                                    $nextTick(() => $el.closest('form').submit());
                                                }
                                            "
                                            aria-label="Giảm số lượng"
                                        >−</button>
                                        <input
                                            type="number"
                                            name="quantity"
                                            x-model="quantity"
                                            x-ref="quantityInput"
                                            min="0"
                                            max="{{ !empty($item['variant_id']) ? min(99, max(0, (int) ($item['stock'] ?? 0))) : 99 }}"
                                            class="h-9 w-12 text-center text-sm outline-none border-x border-slate-200"
                                        />
                                        <button
                                            type="button"
                                            class="h-9 w-9 inline-flex items-center justify-center text-slate-700 hover:bg-slate-50"
                                            x-on:click.prevent="
                                                const max = parseInt($refs.quantityInput.getAttribute('max'));
                                                if (quantity < max) {
                                                    quantity++;
                                                    $nextTick(() => $el.closest('form').submit());
                                                }
                                            "
                                            aria-label="Tăng số lượng"
                                        >+</button>
                                    </form>
                                </div>

                                <div class="md:col-span-2 flex items-center justify-between md:justify-end gap-3">
                                    <div class="text-sm font-extrabold text-amber-600 text-right whitespace-nowrap min-w-[96px]">
                                        {{ number_format((float) $line, 0, ',', '.') }}đ
                                    </div>

                                    <form method="POST" action="{{ route('cart.remove', ['key' => $key]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:text-red-600 hover:border-red-200" aria-label="Xóa">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 flex items-center justify-between gap-4 flex-wrap">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center h-10 px-5 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-white">
                            ← Tiếp tục mua hàng
                        </a>

                        <form method="POST" action="{{ route('cart.clear') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center h-10 px-5 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold hover:border-red-200 hover:text-red-600">
                                Xóa giỏ hàng
                            </button>
                        </form>
                    </div>
                </section>

                <aside class="lg:col-span-4">
                    <div class="bg-slate-900 text-white rounded-2xl p-6 sticky top-24">
                        <h2 class="text-lg font-extrabold tracking-wide">TÓM TẮT ĐƠN HÀNG</h2>

                        <div class="mt-5 space-y-3 text-sm">
                            <div class="flex items-center justify-between text-slate-200">
                                <span>Thành tiền</span>
                                <span class="font-semibold text-white">{{ number_format((float) $totals['subtotal'], 0, ',', '.') }}đ</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-200">
                                <span>Phí vận chuyển</span>
                                <span class="font-semibold text-emerald-300">FREE</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-200">
                                <span>Thuế (gồm)</span>
                                <span class="font-semibold">Đã bao gồm</span>
                            </div>

                            <div class="pt-4 mt-4 border-t border-white/10 flex items-end justify-between">
                                <span class="text-slate-200">Tổng cộng</span>
                                <span class="text-2xl font-extrabold">{{ number_format((float) $totals['subtotal'], 0, ',', '.') }}đ</span>
                            </div>
                        </div>

                        @if (!empty($canCheckout) && $canCheckout)
                            <a href="{{ route('checkout.create') }}" class="mt-6 inline-flex items-center justify-center w-full h-12 rounded-xl bg-emerald-600 text-white text-sm font-extrabold tracking-wide hover:bg-emerald-500">
                                TIẾN HÀNH ĐẶT HÀNG
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                        @else
                            <div class="mt-6 inline-flex items-center justify-center w-full h-12 rounded-xl bg-slate-400 text-white text-sm font-extrabold tracking-wide cursor-not-allowed opacity-80">
                                KHÔNG THỂ ĐẶT HÀNG
                            </div>
                        @endif

                        <div class="mt-4 text-xs text-slate-300">
                            <div class="flex items-start gap-2">
                                <svg class="mt-0.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Giao dịch an toàn với mã hóa SSL.</span>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        @endif
    </div>

</x-store-layout>