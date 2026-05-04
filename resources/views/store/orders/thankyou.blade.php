<x-store-layout title="Đặt hàng thành công">
<div style="background:#030712; min-height:100vh; padding:32px 24px;">
<div style="max-width:600px; margin:0 auto;">

    {{-- SUCCESS HEADER --}}
    <div style="text-align:center; margin-bottom:32px;">
        <div style="width:56px; height:56px; background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <svg width="24" height="24" fill="none" stroke="#4ade80" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
            </svg>
        </div>
        <h1 style="font-size:22px; font-weight:700; color:#f3f4f6; margin:0 0 8px 0;">Đặt hàng thành công!</h1>
        <p style="font-size:13px; color:#6b7280; margin:0;">Cảm ơn bạn đã tin tưởng mua sắm tại VT Store</p>
    </div>

    {{-- ORDER CODE --}}
    <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:20px 24px; margin-bottom:16px; display:flex; align-items:center; justify-content:space-between; gap:16px;">
        <div>
            <p style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; margin:0 0 6px 0;">Mã đơn hàng</p>
            <p style="font-size:20px; font-weight:700; color:#fbbf24; margin:0; letter-spacing:0.05em;">{{ $order->order_number }}</p>
        </div>
        <div style="font-size:11px; color:#6b7280; text-align:right; line-height:1.6;">
            Dùng mã này và email<br>để tra cứu đơn hàng
        </div>
    </div>

    {{-- ORDER SUMMARY --}}
    <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; overflow:hidden; margin-bottom:16px;">
        <div style="padding:16px 20px; border-bottom:1px solid #1f2937;">
            <p style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; margin:0;">Tóm tắt đơn hàng</p>
        </div>

        <div style="padding:8px 0;">
            @foreach ($order->items as $it)
            <div style="display:flex; justify-content:space-between; align-items:start; gap:12px; padding:10px 20px;">
                <div style="flex:1; min-width:0;">
                    <p style="font-size:13px; color:#f3f4f6; font-weight:500; margin:0; line-height:1.4;">
                        {{ $it->product_name }}
                    </p>
                    <p style="font-size:11px; color:#6b7280; margin:2px 0 0 0;">
                        x{{ $it->quantity }}
                        @if($it->size) · Size {{ $it->size }} @endif
                    </p>
                </div>
                <span style="font-size:13px; color:#d1d5db; font-weight:500; white-space:nowrap;">
                    {{ number_format((float) $it->line_total, 0, ',', '.') }}đ
                </span>
            </div>
            @endforeach
        </div>

        <div style="padding:14px 20px; border-top:1px solid #1f2937; display:flex; justify-content:space-between; align-items:center;">
            <span style="font-size:14px; font-weight:700; color:#f3f4f6;">Tổng cộng</span>
            <span style="font-size:16px; font-weight:700; color:#fbbf24;">
                {{ number_format((float) $order->total, 0, ',', '.') }}đ
            </span>
        </div>
    </div>

    {{-- ACTIONS --}}
    <div style="display:flex; gap:10px;">
        <a href="{{ route('orders.track.form') }}"
           style="flex:1; display:block; padding:11px; background:transparent; border:1px solid #374151; color:#d1d5db; font-size:13px; font-weight:600; border-radius:8px; text-align:center; text-decoration:none;"
           onmouseover="this.style.borderColor='#fbbf24';this.style.color='#fbbf24'"
           onmouseout="this.style.borderColor='#374151';this.style.color='#d1d5db'">
            Tra cứu đơn
        </a>
        <a href="{{ route('products.index') }}"
           style="flex:1; display:block; padding:11px; background:#fbbf24; color:#111827; font-size:13px; font-weight:700; border-radius:8px; text-align:center; text-decoration:none;">
            Tiếp tục mua sắm →
        </a>
    </div>

</div>
</div>
</x-store-layout>