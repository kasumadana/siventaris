<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'SIVENTARIS') }}</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb', // blue-600
                        secondary: '#1e40af', // blue-800
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans antialiased pb-20 md:pb-0">

    <!-- Desktop Header -->
    <header class="hidden md:block bg-white shadow-sm sticky top-0 z-40">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center gap-x-3">
                <img src="{{ asset('images/logo.png') }}" alt="SIVENTARIS" class="h-8 w-auto">
            </div>

            <!-- Desktop Nav -->
            <nav class="flex items-center gap-x-8">
                <a href="{{ route('catalog') }}" class="text-sm font-medium transition-colors hover:text-primary {{ request()->routeIs('catalog') ? 'text-primary' : 'text-gray-600' }}">
                    Catalog
                </a>
                <a href="{{ route('dashboard') }}" class="text-sm font-medium transition-colors hover:text-primary {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-gray-600' }}">
                    Dashboard
                </a>
                <a href="{{ route('print.request') }}" class="text-sm font-medium transition-colors hover:text-primary {{ request()->routeIs('print.request') ? 'text-primary' : 'text-gray-600' }}">
                    Print
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700 transition-colors">
                        Logout
                    </button>
                </form>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">
        {{ $slot }}
    </main>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    <nav class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-50 safe-area-bottom">
        <div class="flex justify-around items-center h-16">
            <!-- Home / Catalog -->
            <a href="{{ route('catalog') }}" class="group flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('catalog') ? 'text-primary' : 'text-gray-500 hover:text-primary' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1 transition-transform group-active:scale-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span class="text-[10px] font-medium">Catalog</span>
            </a>

            <!-- Dashboard / QR -->
            <a href="{{ route('dashboard') }}" class="group flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-gray-500 hover:text-primary' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1 transition-transform group-active:scale-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zm-6 0H6.4M6 20v-2m0 0v-2m0 2h.01M20 20h.01M20 16v2m-8-2v2m-6-16h2M4 8h16M4 4h16m-4 12h.01M4 20h4" />
                </svg>
                <span class="text-[10px] font-medium">My QR</span>
            </a>

            <!-- Print Request -->
            <a href="{{ route('print.request') }}" class="group flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('print.request') ? 'text-primary' : 'text-gray-500 hover:text-primary' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1 transition-transform group-active:scale-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span class="text-[10px] font-medium">Print</span>
            </a>

            <!-- Profile (Logout) -->
             <form method="POST" action="{{ route('logout') }}" class="w-full h-full">
                @csrf
                <button type="submit" class="group flex flex-col items-center justify-center w-full h-full text-gray-500 hover:text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1 transition-transform group-active:scale-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="text-[10px] font-medium">Logout</span>
                </button>
            </form>

        </div>
    </nav>

    <!-- Modal Portal -->
    <div id="modal-portal"></div>

</body>
</html>
