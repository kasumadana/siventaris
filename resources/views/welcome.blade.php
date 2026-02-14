<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SIVENTARIS') }} - Sistem Inventaris Sekolah</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb', // blue-600
                        secondary: '#1e40af', // blue-800
                    },
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                        'fade-in': 'fadeIn 1s ease-out forwards',
                        'bounce-slow': 'bounce 3s infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased selection:bg-primary/20 selection:text-primary">

    <nav x-data="{ scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         :class="{ 'bg-white/90 backdrop-blur-md border-b border-gray-100 shadow-sm': scrolled, 'bg-transparent border-transparent': !scrolled }"
         class="fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="SIVENTARIS" class="h-10 w-auto">
                </div>
                
                <div>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-primary hover:bg-secondary text-white font-medium rounded-full text-sm transition-all shadow-lg shadow-blue-500/30 hover:shadow-blue-600/40 hover:-translate-y-0.5">
                            Dashboard Saya
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="group relative px-6 py-2.5 bg-white text-primary border-2 border-primary/20 hover:border-primary font-bold rounded-xl text-sm transition-all hover:shadow-lg">
                            <span class="relative z-10">Login Siswa</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-16 lg:pt-48 lg:pb-40 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center" 
             x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)">
            
            <div x-show="shown" 
                 x-transition:enter="transition duration-1000 transform ease-out"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 border border-blue-100 text-primary text-xs sm:text-sm font-bold mb-6">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                Sistem Peminjaman Terintegrasi SMKN 1 Denpasar
            </div>

            <h1 x-show="shown" 
                x-transition:enter="transition delay-200 duration-1000 transform ease-out"
                x-transition:enter-start="opacity-0 translate-y-8"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="text-4xl sm:text-5xl lg:text-7xl font-bold tracking-tight mb-6 leading-tight text-gray-900">
                Satu Sekolah,<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">
                    Ribuan Fasilitas.
                </span>
            </h1>
            
            <p x-show="shown" 
               x-transition:enter="transition delay-400 duration-1000 transform ease-out"
               x-transition:enter-start="opacity-0 translate-y-8"
               x-transition:enter-end="opacity-100 translate-y-0"
               class="text-base sm:text-lg text-gray-500 max-w-2xl mx-auto mb-10 leading-relaxed px-4">
                Platform kolaborasi lintas jurusan. Pinjam kamera DKV, bor TPM, atau alat jaringan TKJ cukup dengan satu akun siswa.
            </p>

            <div x-show="shown" 
                 x-transition:enter="transition delay-600 duration-1000 transform ease-out"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="flex flex-col sm:flex-row gap-4 justify-center items-center px-4">
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-primary to-secondary hover:shadow-xl hover:shadow-blue-900/20 text-white font-bold rounded-2xl text-lg transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                    Mulai Peminjaman
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
                <a href="#alur" class="w-full sm:w-auto px-8 py-4 bg-white border border-gray-200 text-gray-700 font-bold rounded-2xl text-lg hover:bg-gray-50 hover:border-gray-300 transition-all">
                    Lihat Alur
                </a>
            </div>
        </div>

        <!-- Decorative Blob -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] sm:w-[500px] sm:h-[500px] lg:w-[800px] lg:h-[800px] bg-gradient-to-tr from-blue-100 to-transparent rounded-full blur-3xl -z-10 opacity-60 animate-pulse"></div>
    </section>

    <!-- Departments Grid -->
    <section class="py-12 bg-white border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs sm:text-sm font-bold text-gray-400 uppercase tracking-widest mb-8">Didukung Oleh 12 Jurusan Kompetensi</p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4">
                @if(isset($departments))
                    @foreach($departments as $dept)
                    <div class="group p-4 rounded-xl bg-gray-50 border border-transparent hover:border-primary/20 hover:bg-blue-50 transition-all duration-300 cursor-default text-center hover:scale-105 transform">
                        <span class="block text-xl sm:text-2xl font-bold text-gray-900 group-hover:text-primary mb-1">{{ $dept->value }}</span>
                        <span class="text-[10px] uppercase font-bold text-gray-400 group-hover:text-primary/70">Jurusan</span>
                    </div>
                    @endforeach
                @else
                    <div class="col-span-full text-center text-gray-400">Data Jurusan Sedang Dimuat...</div>
                @endif
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="alur" class="py-20 lg:py-28 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16" 
                 x-data="{ shown: false }" x-intersect.once="shown = true">
                <h2 x-show="shown" 
                    x-transition:enter="transition duration-700 ease-out"
                    x-transition:enter-start="opacity-0 translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Sistem Peminjaman Terpusat
                </h2>
                <p x-show="shown" 
                   x-transition:enter="transition delay-200 duration-700 ease-out"
                   x-transition:enter-start="opacity-0 translate-y-8"
                   x-transition:enter-end="opacity-100 translate-y-0"
                   class="text-gray-500 px-4">
                    Tidak perlu surat manual. Cukup gunakan akun sekolahmu, datangi Ruang Guru jurusan terkait, dan scan QR.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div x-data="{ shown: false }" x-intersect.once="shown = true"
                     class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: 0ms;">
                    
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="text-6xl font-bold text-primary">01</span>
                    </div>
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Cari di Katalog</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Login dan cari barang yang tersedia di jurusan lain. Cek stok secara <i>real-time</i> sebelum meminjam.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div x-data="{ shown: false }" x-intersect.once="shown = true"
                     class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: 150ms;">

                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="text-6xl font-bold text-primary">02</span>
                    </div>
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Ke Ruang Guru</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Barang disimpan aman di <strong>Ruang Guru</strong> tiap jurusan. Temui Toolman atau Kaprog untuk pengambilan.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div x-data="{ shown: false }" x-intersect.once="shown = true"
                     class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: 300ms;">

                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="text-6xl font-bold text-primary">03</span>
                    </div>
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="m8.5,4h-2c-1.378,0-2.5,1.122-2.5,2.5v2c0,1.378,1.122,2.5,2.5,2.5h2c1.378,0,2.5-1.122,2.5-2.5v-2c0-1.378-1.122-2.5-2.5-2.5Zm.5,4.5c0,.276-.224.5-.5.5h-2c-.276,0-.5-.224-.5-.5v-2c0-.276.224-.5.5-.5h2c.276,0,.5.224.5.5v2Zm6.5,2.5h2c1.378,0,2.5-1.122,2.5-2.5v-2c0-1.378-1.122-2.5-2.5-2.5h-2c-1.378,0-2.5,1.122-2.5,2.5v2c0,1.378,1.122,2.5,2.5,2.5Zm-.5-4.5c0-.276.224-.5.5-.5h2c.276,0,.5.224.5.5v2c0,.276-.224.5-.5.5h-2c-.276,0-.5-.224-.5-.5v-2Zm-6.5,6.5h-2c-1.378,0-2.5,1.122-2.5,2.5v2c0,1.378,1.122,2.5,2.5,2.5h2c1.378,0,2.5-1.122,2.5-2.5v-2c0-1.378-1.122-2.5-2.5-2.5Zm.5,4.5c0,.276-.224.5-.5.5h-2c-.276,0-.5-.224-.5-.5v-2c0-.276.224-.5.5-.5h2c.276,0,.5.224.5.5v2Zm-1,5.5c0,.552-.448,1-1,1h-2c-2.757,0-5-2.243-5-5v-2c0-.552.448-1,1-1s1,.448,1,1v2c0,1.654,1.346,3,3,3h2c.552,0,1,.448,1,1Zm16-6v2c0,2.757-2.243,5-5,5h-2c-.552,0-1-.448-1-1s.448-1,1-1h2c1.654,0,3-1.346,3-3v-2c0-.552.448-1,1-1s1,.448,1,1Zm0-12v2c0,.552-.448,1-1,1s-1-.448-1-1v-2c0-1.654-1.346-3-3-3h-2c-.552,0-1-.448-1-1s.448-1,1-1h2c2.757,0,5,2.243,5,5ZM0,7v-2C0,2.243,2.243,0,5,0h2c.552,0,1,.448,1,1s-.448,1-1,1h-2c-1.654,0-3,1.346-3,3v2c0,.552-.448,1-1,1s-1-.448-1-1Zm16,11.5c0,.828-.672,1.5-1.5,1.5s-1.5-.672-1.5-1.5.672-1.5,1.5-1.5,1.5.672,1.5,1.5Zm2.5-5.5c.828,0,1.5.672,1.5,1.5s-.672,1.5-1.5,1.5-1.5-.672-1.5-1.5.672-1.5,1.5-1.5Zm-5.5,1.5c0-.828.672-1.5,1.5-1.5s1.5.672,1.5,1.5-.672,1.5-1.5,1.5-1.5-.672-1.5-1.5Z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Scan QR Code</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Scan QR Code pada fisik barang menggunakan dashboard Siventaris untuk validasi peminjaman.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 opacity-80">
            </div>
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} SMK Negeri 1 Denpasar.
            </p>
        </div>
    </footer>

</body>
</html>