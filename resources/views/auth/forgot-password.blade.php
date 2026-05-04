<x-guest-layout>
    <h1 style="font-size:18px; font-weight:700; color:#f3f4f6; text-align:center; margin:0 0 4px 0;">Quên mật khẩu</h1>
    <p style="font-size:13px; color:#6b7280; text-align:center; margin:0 0 24px 0;">Nhập email để nhận link đặt lại mật khẩu.</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" style="display:flex; flex-direction:column; gap:14px;">
        @csrf

        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
            <x-input-error :messages="$errors->get('email')" class="mt-1" style="color:#f87171; font-size:12px;" />
        </div>

        <button type="submit"
            style="width:100%; padding:12px; background:#fbbf24; color:#111827; font-size:14px; font-weight:700; border-radius:8px; border:none; cursor:pointer; margin-top:4px;">
            Gửi link đặt lại mật khẩu
        </button>
    </form>

    <p style="text-align:center; font-size:13px; color:#6b7280; margin-top:20px;">
        <a href="{{ route('login') }}" style="color:#fbbf24; text-decoration:none; font-weight:600;">← Quay lại đăng nhập</a>
    </p>
</x-guest-layout>