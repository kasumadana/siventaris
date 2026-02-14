<div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
    
    <div class="p-8 sm:p-10">
        <!-- Header -->
        <div class="text-center mb-10">
            <a href="/" class="inline-block mb-4 hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/logo.png') }}" alt="SIVENTARIS" class="h-12 w-auto mx-auto drop-shadow-sm">
            </a>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                Login <span class="text-blue-600">Siswa</span>
            </h2>
            <p class="text-sm text-gray-500 mt-2">
                Masuk untuk mulai meminjam alat & barang.
            </p>
        </div>

        <!-- Form -->
        <form wire:submit="login" class="space-y-6">
            
            <!-- Email -->
            <div class="space-y-2">
                <label for="email" class="text-sm font-semibold text-gray-700 ml-1">Email Sekolah</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input wire:model="email" id="email" type="email" placeholder="nama@sekolah.sch.id" 
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-400 outline-none" required autofocus>
                </div>
                @error('email') <span class="text-red-500 text-xs font-medium ml-1">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <div class="flex justify-between items-center ml-1">
                    <label for="password" class="text-sm font-semibold text-gray-700">Password</label>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input wire:model="password" id="password" type="password" placeholder="••••••••" 
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-400 outline-none" required>
                </div>
                @error('password') <span class="text-red-500 text-xs font-medium ml-1">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-500/30 text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5">
                <span wire:loading.remove>Masuk Sekarang</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                </span>
            </button>
            
        </form>
    </div>
</div>
