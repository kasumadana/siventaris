<div class="space-y-6">
    <!-- Header Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- User Info Card -->
        <div class="md:col-span-2 bg-gradient-to-br from-blue-600 to-blue-800 rounded-3xl p-8 text-white shadow-xl shadow-blue-900/10 relative overflow-hidden flex flex-col justify-center">
            <div class="relative z-10">
                <span class="inline-block px-3 py-1 rounded-full bg-blue-500/30 text-xs font-medium backdrop-blur-sm border border-blue-400/30 mb-3">
                    Student Dashboard
                </span>
                <h1 class="text-3xl font-bold tracking-tight mb-2">Hi, {{ auth()->user()->name }}</h1>
                <p class="text-blue-100 font-medium flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .883-.393 1.627-1.017 2.162a1 1 0 00.322 1.544l1.325.865a1 1 0 01.353.94l-.39 2.593a1 1 0 01-1.356.81l-1.921-.615a1 1 0 00-1.229 0l-1.921.615a1 1 0 01-1.356-.81l-.39-2.593a1 1 0 01.353-.94l1.325-.865a1 1 0 00.322-1.544c-.623-.535-1.017-1.28-1.017-2.162z" />
                    </svg>
                    {{ auth()->user()->student_id_number ?? 'No ID' }} <span class="text-blue-400">|</span> {{ auth()->user()->class_name ?? 'Class N/A' }}
                </p>
            </div>
            
            <!-- Deco Blob -->
            <div class="absolute right-0 top-0 text-white opacity-5 transform translate-x-12 -translate-y-6">
                 <svg class="h-64 w-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="bg-white rounded-3xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-gray-100 p-6 flex flex-col items-center justify-center text-center">
            <div class="p-3 bg-white shadow-inner border border-gray-200 rounded-2xl mb-4">
                {{ $qrCode }}
            </div>
            <h2 class="font-bold text-gray-900">Your Identity QR</h2>
            <p class="text-xs text-gray-500 mt-1 max-w-[200px]">Show this to the Toolman when picking up or returning items.</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-green-50 text-green-700 border border-green-200 rounded-xl flex items-center gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium text-sm">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Active Loans -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    Active Loans
                </h2>
                <span class="bg-gray-100 text-gray-600 px-2.5 py-0.5 rounded-full text-xs font-bold">{{ $activeLoans->count() }}</span>
            </div>
            
            <div class="space-y-3">
                @forelse($activeLoans as $loan)
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                         <div class="absolute top-0 left-0 w-1 h-full {{ $loan->status == 'pending' ? 'bg-yellow-400' : 'bg-green-500' }}"></div>
                    
                        <div class="flex justify-between items-start">
                            <div class="pl-2">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide {{ $loan->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </div>
                                <h3 class="font-bold text-gray-900 group-hover:text-primary transition-colors">
                                    {{ $loan->itemUnit ? $loan->itemUnit->item->name : 'Pending Assignment' }}
                                </h3>
                                <div class="flex items-center gap-4 mt-2 text-xs text-gray-500 font-medium">
                                    <span class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $loan->due_date->format('d M, H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <p class="text-gray-400 text-sm font-medium">No active loans.</p>
                        <a href="{{ route('catalog') }}" class="text-primary text-xs font-bold hover:underline mt-1 inline-block">Borrow something?</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Loan History -->
        <div>
             <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-gray-900 text-lg">History</h2>
                <a href="#" class="text-gray-400 hover:text-gray-600 text-xs font-medium">View All</a>
            </div>
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                @foreach($historyLoans as $loan)
                     <div class="p-4 border-b last:border-0 border-gray-50 hover:bg-gray-50 transition-colors flex justify-between items-center group">
                        <div class="flex items-center gap-3">
                             <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-primary/10 group-hover:text-primary transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                             </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $loan->itemUnit->item->name ?? 'Unknown Item' }}</p>
                                <p class="text-[10px] text-gray-400 uppercase tracking-wide font-medium">{{ $loan->loan_date->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 rounded {{ $loan->status == 'returned' ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }}">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </div>
                @endforeach
                
                @if($historyLoans->isEmpty())
                     <div class="p-6 text-center text-gray-400 text-sm">No history yet.</div>
                @endif
            </div>
        </div>
    </div>
</div>
