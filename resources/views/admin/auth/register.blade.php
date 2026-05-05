<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Register - {{ config('app.name', 'VT Store') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <div class="min-h-screen flex items-center justify-center px-6">
        <div class="w-full max-w-md rounded-xl bg-white border border-gray-200">
            <div class="p-6">
                <h1 class="text-lg font-semibold text-gray-900">Tạo admin đầu tiên</h1>
                <p class="text-sm mt-1 text-gray-500">Chỉ mở khi hệ thống chưa có admin.</p>

                <form method="POST" action="{{ route('admin.register.submit') }}" class="mt-5 space-y-4">
                    @csrf

                    <div>
                        <label class="text-xs text-gray-600">Tên</label>
                        <input name="name" type="text" value="{{ old('name') }}" required
                               class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
                        @error('name')
                            <div class="text-sm mt-2 text-rose-600">{{ $message }}</div>
                        @enderror
                    </div>

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

                    <div>
                           <label class="text-xs text-gray-600">Nhập lại mật khẩu</label>
                        <input name="password_confirmation" type="password" required
                               class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
                    </div>

                    <button type="submit" class="w-full px-4 py-2.5 text-sm font-semibold rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">
                        Tạo admin
                    </button>

                    <div class="text-sm text-gray-600">
                        <a href="{{ route('admin.login') }}" class="font-semibold text-emerald-600 hover:text-emerald-700">Quay lại đăng nhập</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
