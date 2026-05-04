<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="background:#030712;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FootballStore') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background:#030712; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px; font-family:'Figtree',sans-serif;">

    <div style="width:100%; max-width:420px;">

        {{-- Logo --}}
        <a href="{{ route('products.index') }}"
           style="display:flex; align-items:center; justify-content:center; gap:10px; margin-bottom:32px; text-decoration:none;">
            <img src="{{ asset('storage/images/sport.png') }}" style="width:28px; height:28px; object-fit:contain;">
            <span style="font-size:16px; font-weight:700; color:#fff; letter-spacing:0.03em;">
                {{ config('app.name', 'FootballStore') }}
            </span>
        </a>

        {{-- Card --}}
        <div style="background:#111827; border:1px solid #1f2937; border-radius:16px; padding:32px;">
            {{ $slot }}
        </div>

    </div>

</body>
</html>