<x-guest-layout>
    <h1 style="font-size:18px; font-weight:700; color:#f3f4f6; text-align:center; margin:0 0 4px 0;">Đăng nhập</h1>
    <p style="font-size:13px; color:#6b7280; text-align:center; margin:0 0 24px 0;">Chào mừng trở lại!</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" style="display:flex; flex-direction:column; gap:14px;">
        @csrf

        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
            <x-input-error :messages="$errors->get('email')" class="mt-1" style="color:#f87171; font-size:12px;" />
        </div>

        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">Mật khẩu</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
            <x-input-error :messages="$errors->get('password')" class="mt-1" style="color:#f87171; font-size:12px;" />
        </div>

        <div style="display:flex; align-items:center; justify-content:space-between;">
            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                <input id="remember_me" type="checkbox" name="remember"
                    style="width:15px; height:15px; accent-color:#fbbf24; cursor:pointer;">
                <span style="font-size:13px; color:#9ca3af;">Ghi nhớ đăng nhập</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   style="font-size:12px; color:#6b7280; text-decoration:none;"
                   onmouseover="this.style.color='#fbbf24'" onmouseout="this.style.color='#6b7280'">
                    Quên mật khẩu?
                </a>
            @endif
        </div>

        <button type="submit"
            style="width:100%; padding:12px; background:#fbbf24; color:#111827; font-size:14px; font-weight:700; border-radius:8px; border:none; cursor:pointer; margin-top:4px;">
            Đăng nhập
        </button>
    </form>

    <div style="margin-top:12px;">
        <a href="{{ route('auth.google.redirect') }}"
           style="display:flex; align-items:center; justify-content:center; gap:10px; width:100%; padding:11px; background:transparent; border:1px solid #374151; border-radius:8px; font-size:13px; font-weight:600; color:#d1d5db; text-decoration:none; box-sizing:border-box;"
           onmouseover="this.style.borderColor='#6b7280'" onmouseout="this.style.borderColor='#374151'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            Đăng nhập bằng Google
        </a>
    </div>

    <p style="text-align:center; font-size:13px; color:#6b7280; margin-top:20px;">
        Chưa có tài khoản?
        <a href="{{ route('register') }}" style="color:#fbbf24; text-decoration:none; font-weight:600;">Đăng ký</a>
    </p>
</x-guest-layout>