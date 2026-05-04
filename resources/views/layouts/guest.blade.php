<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100">
        <div class="min-h-screen lg:flex">
            <div class="hidden lg:flex lg:w-1/2 bg-gray-900 text-white">
                <div class="w-full flex flex-col justify-between p-12">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-3">
                            <img src="{{ asset('storage/images/logo.png') }}" class="w-7 h-7 object-contain shrink-0" />
                            <div>
                                <div class="text-lg font-semibold">{{ config('app.name', 'Football Store') }}</div>
                                <div class="text-sm text-gray-300">Đồ bóng đá — sẵn sàng ra sân</div>
                            </div>
                        </a>
                    </div>

                    <div class="max-w-md">
                        <div class="text-3xl font-semibold leading-tight">
                            Mua áo đấu, giày và phụ kiện bóng đá
                        </div>
                        <div class="mt-4 text-gray-300">
                            Đăng nhập hoặc tạo tài khoản để theo dõi đơn hàng và cập nhật thông tin cá nhân.
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 text-sm rounded-md bg-white text-gray-900">
                                Xem sản phẩm
                            </a>
                        </div>
                    </div>

                    <div class="text-xs text-gray-400">
                        {{ config('app.name', 'Football Store') }}
                    </div>
                </div>
            </div>

            <div class="flex-1 flex flex-col justify-center items-center px-4 py-10 sm:px-6 lg:px-8">
                <div class="w-full max-w-md">
                    <div class="flex items-center justify-center">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-3">
                            <img src="{{ asset('storage/images/sport.png') }}" class="w-6 h-6 object-contain shrink-0" />
                            <div class="text-base font-semibold text-gray-900">{{ config('app.name', 'Football Store') }}</div>
                        </a>
                    </div>

                    <div class="mt-6 px-6 py-6 bg-white shadow-sm border border-gray-200 overflow-hidden sm:rounded-lg">
                        {{ $slot }}
                    </div>

                    <div class="mt-6 text-center text-xs text-gray-500">
                        <a href="{{ route('products.index') }}" class="hover:underline">Quay lại cửa hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
