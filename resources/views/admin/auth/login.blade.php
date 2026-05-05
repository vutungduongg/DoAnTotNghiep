<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - {{ config('app.name', 'VT Store') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <div class="min-h-screen flex items-center justify-center px-6">
        <div class="w-full max-w-md rounded-xl bg-white border border-gray-200">
            <div class="p-6">
                <h1 class="text-lg font-semibold text-gray-900">Đăng nhập quản trị</h1>
                <p class="text-sm mt-1 text-gray-500">Chỉ tài khoản admin mới đăng nhập được.</p>

                <form method="POST" action="{{ route('admin.login.submit') }}" class="mt-5 space-y-4">
                    @csrf

                    <div>
                        <label class="text-xs text-gray-600">Email</label>
                        <input name="email" type="email" value="{{ old('email') }}" required
                               class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
                        @error('email')
                            <div class="text-sm mt-2 text-rose-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-xs text-gray-600">Mật khẩu</label>
                        <input name="password" type="password" required
                               class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
                        @error('password')
                            <div class="text-sm mt-2 text-rose-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="remember" value="1" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-200" />
                        Ghi nhớ
                    </label>

                    <button type="submit" class="w-full px-4 py-2.5 text-sm font-semibold rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">
                        Đăng nhập
                    </button>

                    <div class="text-sm text-gray-600">
                        @php($hasAdmin = \App\Models\User::query()->where('is_admin', true)->exists())
                        @if(!$hasAdmin)
                            <a href="{{ route('admin.register') }}" class="font-semibold text-emerald-600 hover:text-emerald-700">Tạo admin đầu tiên</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
