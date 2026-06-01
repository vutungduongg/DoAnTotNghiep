@php
    $subtotal = (float) ($totals['subtotal'] ?? 0);
    $shippingFee = 0.0;
    $grandTotal = $subtotal + $shippingFee;
@endphp

<x-store-layout title="Thanh toán - {{ config('app.name', 'VT Store') }}">
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <section class="lg:col-span-8">
                <h1 class="text-2xl font-extrabold tracking-tight">Thông tin nhận hàng</h1>
                <div class="mt-2 h-0.5 w-16 bg-emerald-600"></div>

                <form class="mt-6 bg-white border border-slate-200 rounded-2xl p-6 md:p-7" method="POST" action="{{ route('checkout.store') }}">
                    @csrf

                    @if ($errors->has('stock'))
                        <div class="mb-4 px-4 py-3 rounded-xl text-sm bg-rose-50 border border-rose-200 text-rose-900">
                            {{ $errors->first('stock') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700">Họ và tên</label>
                            <input
                                name="customer_name"
                                value="{{ old('customer_name', $user?->name) }}"
                                required
                                class="mt-2 w-full h-11 px-4 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                            />
                            <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700">Số điện thoại</label>
                            <input
                                name="customer_phone"
                                value="{{ old('customer_phone') }}"
                                required
                                class="mt-2 w-full h-11 px-4 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                            />
                            <x-input-error :messages="$errors->get('customer_phone')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-xs font-semibold text-slate-700">Email</label>
                        <input
                            type="email"
                            name="customer_email"
                            value="{{ old('customer_email', $user?->email) }}"
                            required
                            class="mt-2 w-full h-11 px-4 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                        />
                        <x-input-error :messages="$errors->get('customer_email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <label class="block text-xs font-semibold text-slate-700">Địa chỉ chi tiết</label>
                        <input
                            name="shipping_address"
                            value="{{ old('shipping_address') }}"
                            required
                            placeholder="Số nhà, tên đường, phường/xã..."
                            class="mt-2 w-full h-11 px-4 rounded-xl border border-slate-200 bg-white text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                        />
                        <x-input-error :messages="$errors->get('shipping_address')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <label class="block text-xs font-semibold text-slate-700">Ghi chú đơn hàng (tùy chọn)</label>
                        <textarea
                            name="note"
                            rows="4"
                            placeholder="Lưu ý về thời gian giao hàng, chỉ dẫn địa chỉ..."
                            class="mt-2 w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                        >{{ old('note') }}</textarea>
                        <x-input-error :messages="$errors->get('note')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full h-12 rounded-xl bg-slate-900 text-white text-sm font-extrabold tracking-wide hover:bg-slate-800">
                            XÁC NHẬN ĐẶT HÀNG
                            <span class="ml-2">→</span>
                        </button>
                    </div>
                </form>
            </section>

            <aside class="lg:col-span-4">
                <div class="bg-white border border-slate-200 rounded-2xl p-6 sticky top-24">
                    <h2 class="text-lg font-extrabold">Đơn hàng của bạn</h2>
                    <div class="mt-4 h-px bg-slate-200"></div>

                    <div class="mt-4 space-y-4">
                        @foreach ($items as $item)
                            <div class="flex items-start gap-3">
                                <div class="h-14 w-16 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden shrink-0">
                                    @if (!empty($item['image_path']))
                                        <img src="{{ asset('storage/' . $item['image_path']) }}" alt="{{ $item['name'] }}" class="h-full w-full object-contain" />
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="text-sm font-semibold text-slate-900 leading-snug">{{ $item['name'] }}</div>
                                    <div class="mt-1 text-[11px] text-slate-500">
                                        SIZE: {{ $item['size'] ?: '-' }} · x{{ (int) $item['quantity'] }}
                                    </div>
                                </div>
                                <div class="text-sm font-extrabold text-emerald-700 whitespace-nowrap">
                                    {{ number_format(((float) $item['price']) * (int) $item['quantity'], 0, ',', '.') }}đ
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 border-t border-slate-200 pt-4 space-y-2 text-sm">
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Tạm tính</span>
                            <span class="font-semibold text-slate-900">{{ number_format($subtotal, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Phí vận chuyển</span>
                            <span class="font-semibold text-slate-900">{{ $shippingFee > 0 ? number_format($shippingFee, 0, ',', '.') . 'đ' : 'Miễn phí' }}</span>
                        </div>
                        <div class="mt-3 pt-3 border-t border-dashed border-slate-200 flex items-end justify-between">
                            <span class="text-base font-extrabold text-slate-900">Tổng cộng</span>
                            <span class="text-xl font-extrabold text-slate-900">{{ number_format($grandTotal, 0, ',', '.') }}đ</span>
                        </div>
                    </div>

                    <div class="mt-5">
                        <a href="{{ route('cart.index') }}" class="block text-center text-sm text-slate-600 hover:text-slate-900">
                            ← Quay lại giỏ hàng
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>

</x-store-layout>