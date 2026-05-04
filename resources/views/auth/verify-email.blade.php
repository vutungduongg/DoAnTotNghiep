<x-guest-layout>
    <div style="text-align:center; margin-bottom:24px;">
        <div style="width:52px; height:52px; background:rgba(251,191,36,0.1); border:1px solid rgba(251,191,36,0.3); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 14px;">
            <svg width="22" height="22" fill="none" stroke="#fbbf24" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
            </svg>
        </div>
        <h1 style="font-size:18px; font-weight:700; color:#f3f4f6; margin:0 0 6px 0;">Xác minh email</h1>
        <p style="font-size:13px; color:#6b7280; margin:0; line-height:1.6;">
            Vui lòng kiểm tra email và nhấn vào link xác minh để hoàn tất đăng ký.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div style="background:rgba(34,197,94,0.08); border:1px solid rgba(34,197,94,0.2); border-radius:8px; padding:12px 16px; margin-bottom:16px; text-align:center;">
            <p style="font-size:13px; color:#4ade80; margin:0;">Link xác minh mới đã được gửi đến email của bạn.</p>
        </div>
    @endif

    <div style="display:flex; flex-direction:column; gap:10px;">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                style="width:100%; padding:12px; background:#fbbf24; color:#111827; font-size:14px; font-weight:700; border-radius:8px; border:none; cursor:pointer;">
                Gửi lại email xác minh
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                style="width:100%; padding:11px; background:transparent; border:1px solid #374151; color:#9ca3af; font-size:13px; border-radius:8px; cursor:pointer;"
                onmouseover="this.style.borderColor='#6b7280';this.style.color='#d1d5db'"
                onmouseout="this.style.borderColor='#374151';this.style.color='#9ca3af'">
                Đăng xuất
            </button>
        </form>
    </div>
</x-guest-layout>