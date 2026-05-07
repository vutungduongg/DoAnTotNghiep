<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm text-slate-700">Họ và tên</label>
            <div class="mt-2 relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20.118a7.5 7.5 0 0115 0A18.001 18.001 0 0112 21.75c-2.676 0-5.216-.584-7.5-1.632z" />
                    </svg>
                </span>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    placeholder="Nguyễn Văn A"
                    class="w-full h-11 pl-10 pr-3 rounded-md border border-slate-200 bg-slate-50 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm" />
        </div>

        <div>
            <label class="block text-sm text-slate-700">Số điện thoại</label>
            <div class="mt-2 relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a1.125 1.125 0 01-1.21.38 12.035 12.035 0 01-7.143-7.143 1.125 1.125 0 01.38-1.21l1.293-.97c.363-.272.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                </span>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}" autocomplete="tel"
                    placeholder="0901 234 567"
                    class="w-full h-11 pl-10 pr-3 rounded-md border border-slate-200 bg-slate-50 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300" />
            </div>
            <x-input-error :messages="$errors->get('phone')" class="mt-1 text-sm" />
        </div>

        <div>
            <label class="block text-sm text-slate-700">Email</label>
            <div class="mt-2 relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5A2.25 2.25 0 012.25 17.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5A2.25 2.25 0 002.25 6.75m19.5 0l-9.75 6.75L2.25 6.75" />
                    </svg>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    placeholder="example@gmail.com"
                    class="w-full h-11 pl-10 pr-3 rounded-md border border-slate-200 bg-slate-50 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm" />
        </div>

        <div>
            <label class="block text-sm text-slate-700">Mật khẩu</label>
            <div class="mt-2 relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 0h10.5a1.5 1.5 0 011.5 1.5v7.5a1.5 1.5 0 01-1.5 1.5H6.75a1.5 1.5 0 01-1.5-1.5V12a1.5 1.5 0 011.5-1.5z" />
                    </svg>
                </span>
                <input id="reg_password" type="password" name="password" required autocomplete="new-password"
                    class="w-full h-11 pl-10 pr-10 rounded-md border border-slate-200 bg-slate-50 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300" />
                <button type="button" id="toggle-reg-password" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" aria-label="Hiện/ẩn mật khẩu">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm" />
        </div>

        <div>
            <label class="block text-sm text-slate-700">Xác nhận mật khẩu</label>
            <div class="mt-2 relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </span>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="w-full h-11 pl-10 pr-3 rounded-md border border-slate-200 bg-slate-50 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-sm" />
        </div>

        <button type="submit" class="w-full h-11 rounded-md bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800">
            Đăng ký
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Đã có tài khoản?
        <a href="{{ route('login') }}" class="font-semibold text-slate-900 hover:underline">Đăng nhập</a>
    </p>

    <script>
        (function () {
            const btn = document.getElementById('toggle-reg-password');
            const input = document.getElementById('reg_password');
            if (!btn || !input) return;
            btn.addEventListener('click', function () {
                input.type = input.type === 'password' ? 'text' : 'password';
            });
        })();
    </script>
</x-guest-layout>