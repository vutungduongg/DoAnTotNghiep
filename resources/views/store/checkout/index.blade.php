<x-store-layout title="Đặt hàng">
<div style="background:#030712; min-height:100vh; padding:32px 24px;">
<div style="max-width:1000px; margin:0 auto;">

    <h1 style="font-size:20px; font-weight:700; color:#f3f4f6; margin-bottom:24px;">Đặt hàng</h1>

    <div style="display:grid; grid-template-columns:1fr 340px; gap:24px; align-items:start;">

        {{-- FORM GIAO HÀNG --}}
        <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:28px;">
            <h2 style="font-size:14px; font-weight:600; color:#f3f4f6; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:24px;">
                Thông tin giao hàng
            </h2>

            <form method="POST" action="{{ route('checkout.store') }}" style="display:flex; flex-direction:column; gap:16px;">
                @csrf

                {{-- Họ tên --}}
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">
                        Họ tên <span style="color:#ef4444;">*</span>
                    </label>
                    <input name="customer_name" value="{{ old('customer_name', $user?->name) }}" required
                        style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                        onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
                    <x-input-error :messages="$errors->get('customer_name')" class="mt-1" style="color:#f87171; font-size:12px;" />
                </div>

                {{-- Email --}}
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">
                        Email <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="email" name="customer_email" value="{{ old('customer_email', $user?->email) }}" required
                        style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                        onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
                    <x-input-error :messages="$errors->get('customer_email')" class="mt-1" style="color:#f87171; font-size:12px;" />
                </div>

                {{-- SĐT --}}
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">
                        Số điện thoại <span style="color:#ef4444;">*</span>
                    </label>
                    <input name="customer_phone" value="{{ old('customer_phone') }}" required
                        style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                        onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
                    <x-input-error :messages="$errors->get('customer_phone')" class="mt-1" style="color:#f87171; font-size:12px;" />
                </div>

                {{-- Địa chỉ --}}
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">
                        Địa chỉ giao hàng <span style="color:#ef4444;">*</span>
                    </label>
                    <input name="shipping_address" value="{{ old('shipping_address') }}" required
                        style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                        onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
                    <x-input-error :messages="$errors->get('shipping_address')" class="mt-1" style="color:#f87171; font-size:12px;" />
                </div>

                {{-- Ghi chú --}}
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">
                        Ghi chú
                    </label>
                    <textarea name="note" rows="3"
                        style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; resize:vertical; box-sizing:border-box;"
                        onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">{{ old('note') }}</textarea>
                    <x-input-error :messages="$errors->get('note')" class="mt-1" style="color:#f87171; font-size:12px;" />
                </div>

                <div style="padding-top:8px;">
                    <button type="submit"
                        style="width:100%; padding:13px; background:#fbbf24; color:#111827; font-size:14px; font-weight:700; border-radius:8px; border:none; cursor:pointer;">
                        Xác nhận đặt hàng →
                    </button>
                </div>
            </form>
        </div>

        {{-- ĐƠN HÀNG --}}
        <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:24px; position:sticky; top:84px;">
            <h2 style="font-size:14px; font-weight:600; color:#f3f4f6; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:20px;">
                Đơn hàng
            </h2>

            <div style="display:flex; flex-direction:column; gap:12px;">
                @foreach ($items as $item)
                <div style="display:flex; justify-content:space-between; align-items:start; gap:12px;">
                    <div style="flex:1; min-width:0;">
                        <p style="font-size:13px; color:#f3f4f6; font-weight:500; line-height:1.4; margin:0;">
                            {{ $item['name'] }}
                        </p>
                        <p style="font-size:11px; color:#6b7280; margin:2px 0 0 0;">
                            x{{ $item['quantity'] }}
                            @if ($item['size']) · Size {{ $item['size'] }} @endif
                        </p>
                    </div>
                    <span style="font-size:13px; color:#d1d5db; white-space:nowrap; font-weight:500;">
                        {{ number_format(((float) $item['price']) * (int) $item['quantity'], 0, ',', '.') }}đ
                    </span>
                </div>
                @endforeach
            </div>

            <div style="margin-top:20px; padding-top:16px; border-top:1px solid #1f2937; display:flex; flex-direction:column; gap:10px;">
                <div style="display:flex; justify-content:space-between; font-size:13px; color:#9ca3af;">
                    <span>Tạm tính</span>
                    <span style="color:#d1d5db;">{{ number_format((float) $totals['subtotal'], 0, ',', '.') }}đ</span>
                </div>
                <div style="display:flex; justify-content:space-between; font-size:13px; color:#9ca3af;">
                    <span>Phí ship</span>
                    <span style="color:#4ade80; font-weight:600;">Miễn phí</span>
                </div>
                <div style="display:flex; justify-content:space-between; font-size:15px; font-weight:700; color:#f3f4f6; padding-top:10px; border-top:1px solid #1f2937;">
                    <span>Tổng cộng</span>
                    <span style="color:#fbbf24;">{{ number_format((float) $totals['subtotal'], 0, ',', '.') }}đ</span>
                </div>
            </div>

            <a href="{{ route('cart.index') }}"
               style="display:block; text-align:center; font-size:12px; color:#6b7280; text-decoration:none; margin-top:16px;"
               onmouseover="this.style.color='#fbbf24'" onmouseout="this.style.color='#6b7280'">
                ← Quay lại giỏ hàng
            </a>
        </div>

    </div>
</div>
</div>
</x-store-layout>