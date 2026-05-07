<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'VT Store') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-100 text-slate-900 min-h-screen flex flex-col">
    <div class="flex-1 flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md">
            <div class="text-center">
                <a href="{{ url('/') }}" class="inline-block text-3xl font-extrabold tracking-tight hover:opacity-90">VT STORE</a>
                <div class="mt-2 text-sm text-slate-500">Chuyên gia trang phục bóng đá.</div>
            </div>

            <div class="relative mt-8">
                <div class="absolute -left-28 -bottom-20 hidden md:block opacity-15">
                    <svg width="180" height="180" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="100" cy="100" r="92" stroke="currentColor" stroke-width="12" class="text-slate-400" />
                        <path d="M100 35L128 55L121 88H79L72 55L100 35Z" stroke="currentColor" stroke-width="10" class="text-slate-400" />
                        <path d="M72 55L45 78L58 110L79 88" stroke="currentColor" stroke-width="10" class="text-slate-400" />
                        <path d="M128 55L155 78L142 110L121 88" stroke="currentColor" stroke-width="10" class="text-slate-400" />
                        <path d="M58 110L67 145L100 155L133 145L142 110" stroke="currentColor" stroke-width="10" class="text-slate-400" />
                    </svg>
                </div>

                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <footer class="border-t border-slate-200 bg-slate-100">
        <div class="max-w-6xl mx-auto px-4 py-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <div class="flex items-center gap-3">
                <span class="font-semibold text-slate-700">VT STORE</span>
                <span class="hidden sm:inline">© {{ date('Y') }} VT STORE. Chuyên gia trang phục bóng đá.</span>
            </div>
            <div class="flex items-center gap-5 uppercase tracking-wide">
                <a href="#" class="hover:text-slate-900">Terms</a>
                <a href="#" class="hover:text-slate-900">Privacy</a>
                <a href="#" class="hover:text-slate-900">Shipping</a>
                <a href="#" class="hover:text-slate-900">Returns</a>
                <a href="#" class="hover:text-slate-900">Contact</a>
            </div>
        </div>
    </footer>
</body>
</html>