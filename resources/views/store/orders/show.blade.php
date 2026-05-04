<x-store-layout :title="'Đơn hàng '.$order->order_number">
<div style="background:#030712; min-height:100vh; padding:32px 24px;">
<div style="max-width:800px; margin:0 auto;">

    @php
        $statusColor = match($order->status) {
            'pending'    => ['bg' => 'rgba(251,191,36,0.1)',  'color' => '#fbbf24',  'text' => 'Chờ xử lý'],
            'processing' => ['bg' => 'rgba(59,130,246,0.1)', 'color' => '#60a5fa',  'text' => 'Đang xử lý'],
            'shipping'   => ['bg' => 'rgba(139,92,246,0.1)', 'color' => '#a78bfa',  'text' => 'Đang giao'],
            'completed'  => ['bg' => 'rgba(34,197,94,0.1)',  'color' => '#4ade80',  'text' => 'Hoàn thành'],
            'cancelled'  => ['bg' => 'rgba(239,68,68,0.1)',  'color' => '#f87171',  'text' => 'Đã hủy'],
            default      => ['bg' => 'rgba(107,114,128,0.1)','color' => '#9ca3af',  'text' => ucfirst($order->status)],
        };
    @endphp

    {{-- HEADER --}}
    <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-bottom:24px;">
        <div>
            <p style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; margin:0 0 4px 0;">Đơn hàng</p>
            <h1 style="font-size:20px; font-weight:700; color:#f3f4f6; margin:0; font-family:monospace; letter-spacing:0.03em;">
                {{ $order->order_number }}
            </h1>
        </div>
        <div style="display:flex; align-items:center; gap:12px;">
            <span style="padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; background:{{ $statusColor['bg'] }}; color:{{ $statusColor['color'] }};">
                {{ $statusColor['text'] }}
            </span>
            <span style="font-size:12px; color:#6b7280;">{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>

    {{-- GUEST NOTICE --}}
    @if ($isGuest)
    <div style="background:rgba(59,130,246,0.08); border:1px solid rgba(59,130,246,0.2); border-radius:8px; padding:12px 16px; margin-bottom:20px; font-size:13px; color:#93c5fd;">
        Bạn đang xem đơn hàng theo chế độ tra cứu.
    </div>
    @endif

    {{-- INFO GRID --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
        <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:20px;">
            <p style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; margin:0 0 12px 0;">Khách hàng</p>
            <p style="font-size:14px; font-weight:600; color:#f3f4f6; margin:0 0 4px 0;">{{ $order->customer_name }}</p>
            <p style="font-size:13px; color:#9ca3af; margin:0 0 2px 0;">{{ $order->customer_email }}</p>
            <p style="font-size:13px; color:#9ca3af; margin:0;">{{ $order->customer_phone }}</p>
        </div>
        <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:20px;">
            <p style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; margin:0 0 12px 0;">Địa chỉ giao hàng</p>
            <p style="font-size:13px; color:#d1d5db; line-height:1.6; margin:0;">{{ $order->shipping_address }}</p>
        </div>
    </div>

    {{-- PRODUCTS --}}
    <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; overflow:hidden; margin-bottom:16px;">
        <div style="padding:16px 20px; border-bottom:1px solid #1f2937;">
            <p style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; margin:0;">Sản phẩm</p>
        </div>

        {{-- Col headers --}}
        <div style="display:grid; grid-template-columns:2fr 80px 120px 60px 130px; gap:12px; padding:10px 20px; border-bottom:1px solid #1f2937;">
            <span style="font-size:11px; color:#4b5563; font-weight:600; text-transform:uppercase; letter-spacing:0.04em;">Tên</span>
            <span style="font-size:11px; color:#4b5563; font-weight:600; text-transform:uppercase; letter-spacing:0.04em;">Size</span>
            <span style="font-size:11px; color:#4b5563; font-weight:600; text-transform:uppercase; letter-spacing:0.04em;">Đơn giá</span>
            <span style="font-size:11px; color:#4b5563; font-weight:600; text-transform:uppercase; letter-spacing:0.04em;">SL</span>
            <span style="font-size:11px; color:#4b5563; font-weight:600; text-transform:uppercase; letter-spacing:0.04em; text-align:right;">Thành tiền</span>
        </div>

        @foreach ($order->items as $it)
        <div style="display:grid; grid-template-columns:2fr 80px 120px 60px 130px; gap:12px; align-items:center; padding:14px 20px; border-bottom:1px solid #1f2937;">
            <span style="font-size:13px; font-weight:600; color:#f3f4f6;">{{ $it->product_name }}</span>
            <span style="font-size:13px; color:#9ca3af;">{{ $it->size ?? '-' }}</span>
            <span style="font-size:13px; color:#d1d5db;">{{ number_format((float) $it->unit_price, 0, ',', '.') }}đ</span>
            <span style="font-size:13px; color:#d1d5db;">{{ $it->quantity }}</span>
            <span style="font-size:13px; font-weight:600; color:#fbbf24; text-align:right;">{{ number_format((float) $it->line_total, 0, ',', '.') }}đ</span>
        </div>
        @endforeach

        {{-- TOTALS --}}
        <div style="padding:16px 20px; display:flex; flex-direction:column; gap:8px;">
            <div style="display:flex; justify-content:flex-end; gap:48px; font-size:13px; color:#9ca3af;">
                <span>Tạm tính</span>
                <span style="color:#d1d5db; min-width:120px; text-align:right;">{{ number_format((float) $order->subtotal, 0, ',', '.') }}đ</span>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:48px; font-size:13px; color:#9ca3af;">
                <span>Phí ship</span>
                <span style="min-width:120px; text-align:right; {{ $order->shipping_fee == 0 ? 'color:#4ade80; font-weight:600;' : 'color:#d1d5db;' }}">
                    {{ $order->shipping_fee == 0 ? 'Miễn phí' : number_format((float) $order->shipping_fee, 0, ',', '.') . 'đ' }}
                </span>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:48px; font-size:15px; font-weight:700; padding-top:10px; border-top:1px solid #1f2937;">
                <span style="color:#f3f4f6;">Tổng cộng</span>
                <span style="color:#fbbf24; min-width:120px; text-align:right;">{{ number_format((float) $order->total, 0, ',', '.') }}đ</span>
            </div>
        </div>
    </div>

    {{-- NOTE --}}
    @if ($order->note)
    <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:20px; margin-bottom:16px;">
        <p style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; margin:0 0 8px 0;">Ghi chú</p>
        <p style="font-size:13px; color:#d1d5db; line-height:1.6; white-space:pre-line; margin:0;">{{ $order->note }}</p>
    </div>
    @endif

    {{-- BACK --}}
    <div style="display:flex; gap:10px;">
        <a href="{{ route('products.index') }}"
           style="padding:10px 20px; background:#fbbf24; color:#111827; font-size:13px; font-weight:700; border-radius:8px; text-decoration:none;">
            Tiếp tục mua sắm →
        </a>
        @auth
        <a href="{{ route('orders.index') }}"
           style="padding:10px 20px; background:transparent; border:1px solid #374151; color:#9ca3af; font-size:13px; border-radius:8px; text-decoration:none;"
           onmouseover="this.style.borderColor='#fbbf24';this.style.color='#fbbf24'"
           onmouseout="this.style.borderColor='#374151';this.style.color='#9ca3af'">
            ← Danh sách đơn
        </a>
        @endauth
    </div>

</div>
</div>
</x-store-layout>