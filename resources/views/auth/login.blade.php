<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-[11px] font-semibold tracking-widest uppercase text-slate-600">Email hoặc tên đăng nhập</label>
            <div class="mt-2 relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20.118a7.5 7.5 0 0115 0A18.001 18.001 0 0112 21.75c-2.676 0-5.216-.584-7.5-1.632z" />
                    </svg>
                </span>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="VD: football.pro@example.com"
                    class="w-full h-11 pl-10 pr-3 rounded-md border border-slate-200 bg-slate-50 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm" />
        </div>

        <div>
            <label class="block text-[11px] font-semibold tracking-widest uppercase text-slate-600">Mật khẩu</label>
            <div class="mt-2 relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 0h10.5a1.5 1.5 0 011.5 1.5v7.5a1.5 1.5 0 01-1.5 1.5H6.75a1.5 1.5 0 01-1.5-1.5V12a1.5 1.5 0 011.5-1.5z" />
                    </svg>
                </span>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="w-full h-11 pl-10 pr-10 rounded-md border border-slate-200 bg-slate-50 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300"
                />
                <button
                    type="button"
                    id="toggle-password"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600"
                    aria-label="Hiện/ẩn mật khẩu"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm" />
        </div>

        <div class="flex items-center justify-between">
            <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-slate-900 focus:ring-slate-900/10" />
                <span>Ghi nhớ đăng nhập</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-slate-800 hover:text-slate-900">Quên mật khẩu?</a>
            @endif
        </div>

        <button type="submit" class="w-full h-11 rounded-md bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 inline-flex items-center justify-center gap-2">
            ĐĂNG NHẬP
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
        </button>

        <div class="pt-2">
            <div class="flex items-center gap-4">
                <div class="h-px bg-slate-200 flex-1"></div>
                <div class="text-xs tracking-widest text-slate-400">HOẶC</div>
                <div class="h-px bg-slate-200 flex-1"></div>
            </div>

            <div class="mt-4 grid grid-cols-2 gap-3">
                <a href="{{ route('auth.google.redirect') }}" class="h-11 rounded-md border border-slate-200 bg-white text-sm font-semibold text-slate-800 hover:bg-slate-50 inline-flex items-center justify-center gap-2">
                    <span class="inline-flex h-5 w-5 items-center justify-center">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                    </span>
                    Google
                </a>

                <button type="button" disabled class="h-11 rounded-md border border-slate-200 bg-white text-sm font-semibold text-slate-800 inline-flex items-center justify-center gap-2 opacity-60 cursor-not-allowed">
                    <span class="inline-flex h-5 w-5 items-center justify-center text-blue-600">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M22 12.06C22 6.52 17.52 2 11.94 2 6.52 2 2 6.52 2 12.06 2 17.06 5.66 21.2 10.44 22v-7.02H7.9v-2.92h2.54V9.84c0-2.5 1.5-3.88 3.78-3.88 1.1 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.62.77-1.62 1.56v1.88h2.76l-.44 2.92h-2.32V22C18.34 21.2 22 17.06 22 12.06Z"/>
                        </svg>
                    </span>
                    Facebook
                </button>
            </div>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Chưa có tài khoản?
        <a href="{{ route('register') }}" class="font-semibold text-slate-900 hover:underline">Đăng ký ngay</a>
    </p>

    <script>
        (function () {
            const btn = document.getElementById('toggle-password');
            const input = document.getElementById('password');
            if (!btn || !input) return;
            btn.addEventListener('click', function () {
                input.type = input.type === 'password' ? 'text' : 'password';
            });
        })();
    </script>
</x-guest-layout>