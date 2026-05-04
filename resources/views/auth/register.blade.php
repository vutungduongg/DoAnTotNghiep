<x-guest-layout>
    <h1 style="font-size:18px; font-weight:700; color:#f3f4f6; text-align:center; margin:0 0 4px 0;">Tạo tài khoản</h1>
    <p style="font-size:13px; color:#6b7280; text-align:center; margin:0 0 24px 0;">Đăng ký để theo dõi đơn hàng dễ dàng hơn.</p>

    <form method="POST" action="{{ route('register') }}" style="display:flex; flex-direction:column; gap:14px;">
        @csrf

        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">Họ và tên</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
            <x-input-error :messages="$errors->get('name')" class="mt-1" style="color:#f87171; font-size:12px;" />
        </div>

        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
            <x-input-error :messages="$errors->get('email')" class="mt-1" style="color:#f87171; font-size:12px;" />
        </div>

        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">Mật khẩu</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
            <x-input-error :messages="$errors->get('password')" class="mt-1" style="color:#f87171; font-size:12px;" />
        </div>

        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">Xác nhận mật khẩu</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" style="color:#f87171; font-size:12px;" />
        </div>

        <button type="submit"
            style="width:100%; padding:12px; background:#fbbf24; color:#111827; font-size:14px; font-weight:700; border-radius:8px; border:none; cursor:pointer; margin-top:4px;">
            Tạo tài khoản
        </button>
    </form>

    <p style="text-align:center; font-size:13px; color:#6b7280; margin-top:20px;">
        Đã có tài khoản?
        <a href="{{ route('login') }}" style="color:#fbbf24; text-decoration:none; font-weight:600;">Đăng nhập</a>
    </p>
</x-guest-layout>