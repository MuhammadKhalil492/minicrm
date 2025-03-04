<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="robots" content="noindex, nofollow" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
    @vite(['resources/css/dashboard.css', 'resources/js/app.js'])
    @filamentStyles
    @livewireStyles
</head>

<body class="min-h-screen font-sans antialiased dark:bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-dashboard.includes.nav />

    {{-- MAIN --}}
    <x-mary-main full-width>
        {{-- SIDEBAR --}}
       <x-dashboard.includes.sidebar/>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-mary-main>

    {{-- Toast --}}
    <x-mary-toast />
</body>

</html>
