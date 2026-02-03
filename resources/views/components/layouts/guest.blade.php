<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Login - SIVENTARIS' }}</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased h-screen flex items-center justify-center">

    <main class="w-full max-w-md px-6">
        {{ $slot }}
    </main>

</body>
</html>
