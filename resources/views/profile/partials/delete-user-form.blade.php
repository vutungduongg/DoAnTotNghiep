<section>
    <h2 style="font-size:14px; font-weight:600; color:#f87171; text-transform:uppercase; letter-spacing:0.05em; margin:0 0 4px 0;">Xóa tài khoản</h2>
    <p style="font-size:13px; color:#6b7280; margin:0 0 20px 0;">Sau khi xóa, toàn bộ dữ liệu sẽ bị xóa vĩnh viễn và không thể khôi phục.</p>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        style="padding:9px 18px; background:transparent; border:1px solid #ef4444; color:#f87171; font-size:13px; font-weight:600; border-radius:8px; cursor:pointer;"
        onmouseover="this.style.background='rgba(239,68,68,0.1)'"
        onmouseout="this.style.background='transparent'">
        Xóa tài khoản
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}"
              style="padding:28px; background:#111827;">
            @csrf
            @method('delete')

            <h2 style="font-size:16px; font-weight:700; color:#f3f4f6; margin:0 0 8px 0;">Bạn chắc chắn muốn xóa tài khoản?</h2>
            <p style="font-size:13px; color:#6b7280; margin:0 0 20px 0; line-height:1.6;">
                Hành động này không thể hoàn tác. Vui lòng nhập mật khẩu để xác nhận.
            </p>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">
                    Mật khẩu
                </label>
                <input id="password" name="password" type="password" placeholder="Nhập mật khẩu"
                    style="width:100%; padding:10px 14px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#ef4444'" onblur="this.style.borderColor='#374151'">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1" style="color:#f87171; font-size:12px;" />
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" x-on:click="$dispatch('close')"
                    style="padding:9px 18px; background:transparent; border:1px solid #374151; color:#9ca3af; font-size:13px; border-radius:8px; cursor:pointer;">
                    Hủy
                </button>
                <button type="submit"
                    style="padding:9px 18px; background:#ef4444; color:#fff; font-size:13px; font-weight:700; border-radius:8px; border:none; cursor:pointer;">
                    Xác nhận xóa
                </button>
            </div>
        </form>
    </x-modal>
</section>