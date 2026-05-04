<section>
    <h2 style="font-size:14px; font-weight:600; color:#f3f4f6; text-transform:uppercase; letter-spacing:0.05em; margin:0 0 4px 0;">Đổi mật khẩu</h2>
    <p style="font-size:13px; color:#6b7280; margin:0 0 24px 0;">Sử dụng mật khẩu dài và ngẫu nhiên để bảo mật tài khoản.</p>

    <form method="post" action="{{ route('password.update') }}" style="display:flex; flex-direction:column; gap:16px;">
        @csrf
        @method('put')

        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">
                Mật khẩu hiện tại
            </label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" style="color:#f87171; font-size:12px;" />
        </div>

        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">
                Mật khẩu mới
            </label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" style="color:#f87171; font-size:12px;" />
        </div>

        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">
                Xác nhận mật khẩu mới
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" style="color:#f87171; font-size:12px;" />
        </div>

        <div style="display:flex; align-items:center; gap:12px; padding-top:4px;">
            <button type="submit"
                style="padding:10px 20px; background:#fbbf24; color:#111827; font-size:13px; font-weight:700; border-radius:8px; border:none; cursor:pointer;">
                Cập nhật mật khẩu
            </button>
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   style="font-size:12px; color:#4ade80;">Đã lưu!</p>
            @endif
        </div>
    </form>
</section>