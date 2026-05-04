<section>
    <h2 style="font-size:14px; font-weight:600; color:#f3f4f6; text-transform:uppercase; letter-spacing:0.05em; margin:0 0 4px 0;">Thông tin cá nhân</h2>
    <p style="font-size:13px; color:#6b7280; margin:0 0 24px 0;">Cập nhật tên và địa chỉ email tài khoản.</p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form method="post" action="{{ route('profile.update') }}" style="display:flex; flex-direction:column; gap:16px;">
        @csrf
        @method('patch')

        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">
                Họ tên
            </label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
            <x-input-error class="mt-1" :messages="$errors->get('name')" style="color:#f87171; font-size:12px;" />
        </div>

        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">
                Email
            </label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                onfocus="this.style.borderColor='#fbbf24'" onblur="this.style.borderColor='#374151'">
            <x-input-error class="mt-1" :messages="$errors->get('email')" style="color:#f87171; font-size:12px;" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top:8px; padding:10px 14px; background:rgba(251,191,36,0.08); border:1px solid rgba(251,191,36,0.2); border-radius:8px;">
                    <p style="font-size:12px; color:#fbbf24; margin:0;">
                        Email chưa được xác minh.
                        <button form="send-verification"
                            style="background:none; border:none; color:#fbbf24; text-decoration:underline; cursor:pointer; font-size:12px; padding:0;">
                            Gửi lại email xác minh
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p style="margin:6px 0 0 0; font-size:12px; color:#4ade80;">Đã gửi link xác minh đến email của bạn.</p>
                    @endif
                </div>
            @endif
        </div>

        <div style="display:flex; align-items:center; gap:12px; padding-top:4px;">
            <button type="submit"
                style="padding:10px 20px; background:#fbbf24; color:#111827; font-size:13px; font-weight:700; border-radius:8px; border:none; cursor:pointer;">
                Lưu thay đổi
            </button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   style="font-size:12px; color:#4ade80;">Đã lưu!</p>
            @endif
        </div>
    </form>
</section>