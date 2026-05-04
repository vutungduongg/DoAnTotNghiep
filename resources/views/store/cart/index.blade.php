<x-store-layout title="Giỏ hàng">
<div style="background:#030712; min-height:100vh; padding:32px 24px;">
<div style="max-width:900px; margin:0 auto;">

    <h1 style="font-size:20px; font-weight:700; color:#f3f4f6; margin-bottom:24px;">
        Giỏ hàng
    </h1>

    @if ($items === [])
        <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:48px; text-align:center;">
            <p style="color:#6b7280; font-size:14px; margin-bottom:16px;">Giỏ hàng đang trống.</p>
            <a href="{{ route('products.index') }}"
               style="display:inline-block; padding:10px 20px; background:#fbbf24; color:#111827; font-size:13px; font-weight:600; border-radius:8px; text-decoration:none;">
                Xem sản phẩm
            </a>
        </div>
    @else
        <div style="display:flex; flex-direction:column; gap:16px;">

            {{-- ITEMS --}}
            <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; overflow:hidden;">

                {{-- Header --}}
                <div style="display:grid; grid-template-columns:2fr 80px 120px 160px 120px 60px; gap:12px; padding:12px 20px; border-bottom:1px solid #1f2937;">
                    <span style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em;">Sản phẩm</span>
                    <span style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em;">Size</span>
                    <span style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em;">Đơn giá</span>
                    <span style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em;">Số lượng</span>
                    <span style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em;">Thành tiền</span>
                    <span></span>
                </div>

                {{-- Rows --}}
                @foreach ($items as $key => $item)
                    @php $line = (float) $item['price'] * (int) $item['quantity']; @endphp
                    <div style="display:grid; grid-template-columns:2fr 80px 120px 160px 120px 60px; gap:12px; align-items:center; padding:14px 20px; border-bottom:1px solid #1f2937;">

                        {{-- Tên --}}
                        <span style="font-size:13px; font-weight:600; color:#f3f4f6; line-height:1.4;">
                            {{ $item['name'] }}
                        </span>

                        {{-- Size --}}
                        <span style="font-size:13px; color:#9ca3af;">{{ $item['size'] ?? '-' }}</span>

                        {{-- Đơn giá --}}
                        <span style="font-size:13px; color:#d1d5db;">
                            {{ number_format((float) $item['price'], 0, ',', '.') }}đ
                        </span>

                        {{-- Số lượng --}}
                        <form method="POST" action="{{ route('cart.update', ['key' => $key]) }}"
                              style="display:flex; align-items:center; gap:6px;">
                            @csrf
                            @method('PATCH')
                            <div style="display:flex; align-items:center;">
                                <button type="button"
                                    onclick="const i=this.nextElementSibling;i.value=Math.max(0,+i.value-1)"
                                    style="width:28px; height:28px; display:flex; align-items:center; justify-content:center; background:#1f2937; border:1px solid #374151; border-radius:6px 0 0 6px; color:#d1d5db; font-size:14px; cursor:pointer; border-right:none;">−</button>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="0" max="99"
                                style="width:44px; height:28px; text-align:center; background:#1f2937; border-top:1px solid #374151; border-bottom:1px solid #374151; border-left:none; border-right:none; font-size:13px; color:#e5e7eb; outline:none; -moz-appearance:textfield;"
                                oninput="this.style.color='#e5e7eb'">
                                <button type="button"
                                    onclick="const i=this.previousElementSibling;i.value=Math.min(99,+i.value+1)"
                                    style="width:28px; height:28px; display:flex; align-items:center; justify-content:center; background:#1f2937; border:1px solid #374151; border-radius:0 6px 6px 0; color:#d1d5db; font-size:14px; cursor:pointer; border-left:none;">+</button>
                            </div>
                            <button type="submit"
                                style="padding:4px 10px; background:#1f2937; border:1px solid #374151; color:#9ca3af; font-size:11px; border-radius:6px; cursor:pointer; white-space:nowrap;">
                                Lưu
                            </button>
                        </form>

                        {{-- Thành tiền --}}
                        <span style="font-size:13px; font-weight:600; color:#fbbf24;">
                            {{ number_format($line, 0, ',', '.') }}đ
                        </span>

                        {{-- Xóa --}}
                        <form method="POST" action="{{ route('cart.remove', ['key' => $key]) }}"
                              style="display:flex; justify-content:center;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                style="width:28px; height:28px; display:flex; align-items:center; justify-content:center; background:transparent; border:1px solid #374151; border-radius:6px; color:#6b7280; cursor:pointer; transition:all 0.15s;"
                                onmouseover="this.style.borderColor='#ef4444';this.style.color='#ef4444'"
                                onmouseout="this.style.borderColor='#374151';this.style.color='#6b7280'">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </form>

                    </div>
                @endforeach
            </div>

            {{-- FOOTER --}}
            <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">

                {{-- Xóa giỏ --}}
                <form method="POST" action="{{ route('cart.clear') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        style="padding:9px 16px; background:transparent; border:1px solid #374151; color:#9ca3af; font-size:13px; border-radius:8px; cursor:pointer;"
                        onmouseover="this.style.borderColor='#ef4444';this.style.color='#ef4444'"
                        onmouseout="this.style.borderColor='#374151';this.style.color='#9ca3af'">
                        Xóa giỏ hàng
                    </button>
                </form>

                {{-- Tổng + Đặt hàng --}}
                <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:20px 24px; display:flex; flex-direction:column; gap:8px; min-width:260px;">
                    <div style="display:flex; justify-content:space-between; font-size:13px; color:#9ca3af;">
                        <span>Tổng số lượng</span>
                        <span style="color:#d1d5db; font-weight:600;">{{ $totals['total_qty'] }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:15px; font-weight:700; color:#f3f4f6; padding-top:8px; border-top:1px solid #1f2937;">
                        <span>Tạm tính</span>
                        <span style="color:#fbbf24;">{{ number_format((float) $totals['subtotal'], 0, ',', '.') }}đ</span>
                    </div>
                    <a href="{{ route('checkout.create') }}"
                       style="display:block; margin-top:8px; padding:11px; background:#fbbf24; color:#111827; font-size:14px; font-weight:700; border-radius:8px; text-align:center; text-decoration:none;">
                        Đặt hàng →
                    </a>
                    <a href="{{ route('products.index') }}"
                       style="display:block; text-align:center; font-size:12px; color:#6b7280; text-decoration:none; margin-top:4px;"
                       onmouseover="this.style.color='#fbbf24'" onmouseout="this.style.color='#6b7280'">
                        ← Tiếp tục mua sắm
                    </a>
                </div>

            </div>
        </div>
    @endif

</div>
</div>
</x-store-layout>
<style>
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button { -webkit-appearance:none; margin:0; }
input[type=number] { -moz-appearance:textfield; }
</style>