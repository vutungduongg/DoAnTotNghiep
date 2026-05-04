<x-guest-layout>
    <h1 style="font-size:18px; font-weight:700; color:#f3f4f6; text-align:center; margin:0 0 4px 0;">Xác nhận mật khẩu</h1>
    <p style="font-size:13px; color:#6b7280; text-align:center; margin:0 0 24px 0;">Đây là khu vực bảo mật. Vui lòng nhập lại mật khẩu để tiếp tục.</p>

    <form method="POST" action="{{ route('password.confirm') }}" style="display:flex; flex-direction:column; gap:14px;">
        @csrf

        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">Mật khẩu</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
            <x-input-error :messages="$errors->get('password')" class="mt-1" style="color:#f87171; font-size:12px;" />
        </div>

        <button type="submit"
            style="width:100%; padding:12px; background:#fbbf24; color:#111827; font-size:14px; font-weight:700; border-radius:8px; border:none; cursor:pointer; margin-top:4px;">
            Xác nhận
        </button>
    </form>
</x-guest-layout>