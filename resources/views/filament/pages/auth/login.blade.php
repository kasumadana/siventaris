    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 p-8 sm:p-10">
                {{-- Header --}}
                <div class="text-center mb-8">
                    <a href="/" class="inline-block mb-4 hover:opacity-80 transition-opacity">
                        <img src="{{ asset('images/logo.png') }}" alt="SIVENTARIS" class="h-12 w-auto mx-auto drop-shadow-sm">
                    </a>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                        Login <span class="text-primary-600">Admin</span>
                    </h2>
                    <p class="text-sm text-gray-500 mt-2">
                        Portal Khusus Staff & Toolman
                    </p>
                </div>

                {{-- Filament Form --}}
                {{ $this->form }}
                
                {{-- Footer Link --}}
                 <div class="mt-6 text-center">
                     <a href="/login" class="text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors flex items-center justify-center gap-1 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform rotate-180 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                        Kembali ke Login Siswa
                    </a>
                </div>
            </div>
        </div>
    </div>
