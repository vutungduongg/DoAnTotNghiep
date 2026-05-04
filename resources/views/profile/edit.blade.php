<x-store-layout title="Tài khoản">
<div style="background:#030712; min-height:100vh; padding:32px 24px;">
<div style="max-width:680px; margin:0 auto;">

    <h1 style="font-size:20px; font-weight:700; color:#f3f4f6; margin-bottom:24px;">Tài khoản của bạn</h1>

    <div style="display:flex; flex-direction:column; gap:16px;">

        <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:28px;">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:28px;">
            @include('profile.partials.update-password-form')
        </div>

        <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:28px;">
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</div>
</div>
</x-store-layout>