<x-store-layout title="Đơn hàng">
<div style="background:#030712; min-height:100vh; padding:32px 24px;">
<div style="max-width:900px; margin:0 auto;">

    <h1 style="font-size:20px; font-weight:700; color:#f3f4f6; margin-bottom:24px;">Đơn hàng của bạn</h1>

    {{-- STATUS TABS --}}
    <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:20px;">
        <a href="{{ route('orders.index') }}"
           style="padding:6px 14px; font-size:12px; font-weight:600; border-radius:6px; text-decoration:none; border:1px solid; transition:all 0.15s;
                  {{ empty($status) ? 'background:#fbbf24; color:#111827; border-color:#fbbf24;' : 'background:transparent; color:#9ca3af; border-color:#374151;' }}">
            Tất cả
        </a>
        @foreach ($statuses as $st)
            @php $count = $counts[$st] ?? 0; @endphp
            <a href="{{ route('orders.index', ['status' => $st]) }}"
               style="padding:6px 14px; font-size:12px; font-weight:600; border-radius:6px; text-decoration:none; border:1px solid; transition:all 0.15s;
                      {{ ($status === $st) ? 'background:#fbbf24; color:#111827; border-color:#fbbf24;' : 'background:transparent; color:#9ca3af; border-color:#374151;' }}">
                {{ ucfirst($st) }} ({{ $count }})
            </a>
        @endforeach
    </div>

    {{-- TABLE --}}
    <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; overflow:hidden;">

        {{-- Header --}}
        <div style="display:grid; grid-template-columns:2fr 1fr 1fr 1fr 80px; gap:12px; padding:12px 20px; border-bottom:1px solid #1f2937;">
            <span style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em;">Mã đơn</span>
            <span style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em;">Trạng thái</span>
            <span style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em;">Tổng tiền</span>
            <span style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em;">Ngày tạo</span>
            <span></span>
        </div>

        {{-- Rows --}}
        @forelse ($orders as $order)
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
        <div style="display:grid; grid-template-columns:2fr 1fr 1fr 1fr 80px; gap:12px; align-items:center; padding:14px 20px; border-bottom:1px solid #1f2937;">

            <span style="font-size:13px; font-weight:600; color:#f3f4f6; font-family:monospace; letter-spacing:0.03em;">
                {{ $order->order_number }}
            </span>

            <span style="display:inline-flex; align-items:center;">
                <span style="padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; background:{{ $statusColor['bg'] }}; color:{{ $statusColor['color'] }};">
                    {{ $statusColor['text'] }}
                </span>
            </span>

            <span style="font-size:13px; font-weight:600; color:#fbbf24;">
                {{ number_format((float) $order->total, 0, ',', '.') }}đ
            </span>

            <span style="font-size:12px; color:#6b7280;">
                {{ $order->created_at->format('d/m/Y H:i') }}
            </span>

            <div style="text-align:right;">
                <a href="{{ route('orders.show', $order) }}"
                   style="padding:5px 12px; background:#1f2937; border:1px solid #374151; color:#d1d5db; font-size:12px; font-weight:500; border-radius:6px; text-decoration:none;"
                   onmouseover="this.style.borderColor='#fbbf24';this.style.color='#fbbf24'"
                   onmouseout="this.style.borderColor='#374151';this.style.color='#d1d5db'">
                    Xem
                </a>
            </div>
        </div>
        @empty
        <div style="padding:48px 20px; text-align:center;">
            <p style="font-size:13px; color:#6b7280; margin:0 0 12px 0;">Chưa có đơn hàng nào.</p>
            <a href="{{ route('products.index') }}"
               style="display:inline-block; padding:8px 16px; background:#fbbf24; color:#111827; font-size:13px; font-weight:600; border-radius:8px; text-decoration:none;">
                Mua sắm ngay
            </a>
        </div>
        @endforelse
    </div>

    <div style="margin-top:20px;">
        {{ $orders->links() }}
    </div>

</div>
</div>
</x-store-layout>