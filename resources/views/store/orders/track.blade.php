<x-store-layout title="Tra cứu đơn hàng">
<div style="background:#030712; min-height:100vh; padding:32px 24px;">
<div style="max-width:480px; margin:0 auto;">

    <div style="text-align:center; margin-bottom:28px;">
        <div style="width:48px; height:48px; background:rgba(251,191,36,0.1); border:1px solid rgba(251,191,36,0.3); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 14px;">
            <svg width="20" height="20" fill="none" stroke="#fbbf24" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
        </div>
        <h1 style="font-size:20px; font-weight:700; color:#f3f4f6; margin:0 0 6px 0;">Tra cứu đơn hàng</h1>
        <p style="font-size:13px; color:#6b7280; margin:0;">Nhập mã đơn và email để xem trạng thái đơn hàng</p>
    </div>

    <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:28px;">
        <form method="POST" action="{{ route('orders.track') }}" style="display:flex; flex-direction:column; gap:16px;">
            @csrf

            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">
                    Mã đơn hàng <span style="color:#ef4444;">*</span>
                </label>
                <input name="order_number" value="{{ old('order_number') }}" required
                    placeholder="ORD-YYYYMMDD-XXXXXXXX"
                    style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box; font-family:monospace;"
                    onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
                <x-input-error :messages="$errors->get('order_number')" class="mt-1" style="color:#f87171; font-size:12px;" />
            </div>

            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">
                    Email đặt hàng <span style="color:#ef4444;">*</span>
                </label>
                <input type="email" name="customer_email" value="{{ old('customer_email') }}" required
                    placeholder="email@example.com"
                    style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
                <x-input-error :messages="$errors->get('customer_email')" class="mt-1" style="color:#f87171; font-size:12px;" />
            </div>

            <button type="submit"
                style="width:100%; padding:12px; background:#fbbf24; color:#111827; font-size:14px; font-weight:700; border-radius:8px; border:none; cursor:pointer; margin-top:4px;">
                Tra cứu đơn hàng →
            </button>
        </form>
    </div>

    <p style="text-align:center; font-size:12px; color:#4b5563; margin-top:16px;">
        Chưa có đơn hàng?
        <a href="{{ route('products.index') }}" style="color:#fbbf24; text-decoration:none;">Mua sắm ngay</a>
    </p>

</div>
</div>
</x-store-layout>