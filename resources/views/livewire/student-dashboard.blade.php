<div class="space-y-6 pb-20">
    <!-- User Info Card -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-2xl font-bold">Hi, {{ auth()->user()->name }}</h1>
            <p class="text-blue-100 text-sm">{{ auth()->user()->student_id_number ?? 'No Student ID' }} | {{ auth()->user()->class_name ?? 'Class N/A' }}</p>
        </div>
        <div class="absolute right-0 top-0 opacity-10 transform translate-x-4 -translate-y-4">
             <svg class="h-32 w-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
        </div>
    </div>

    <!-- QR Code Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col items-center justify-center">
        <h2 class="font-bold text-gray-800 mb-4">My Student QR</h2>
        <div class="p-2 bg-white border-2 border-dashed border-gray-300 rounded-lg">
            {{ $qrCode }}
        </div>
        <p class="text-xs text-center text-gray-500 mt-2">Show this to the Toolman to borrow items.</p>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-green-100 text-green-700 rounded-lg shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    <!-- Active Loans -->
    <div>
        <h2 class="font-bold text-gray-800 text-lg mb-3">Active & Pending Loans</h2>
        <div class="space-y-3">
            @forelse($activeLoans as $loan)
                <div class="bg-white p-4 rounded-xl shadow-sm border-l-4 {{ $loan->status == 'pending' ? 'border-yellow-400' : 'border-green-500' }}">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-gray-800">
                                {{ $loan->itemUnit ? $loan->itemUnit->item->name : 'Pending Assignment' }}
                            </h3>
                            <p class="text-xs text-gray-500">Due: {{ $loan->due_date->format('d M Y H:i') }}</p>
                        </div>
                        <span class="px-2 py-1 rounded text-xs font-bold {{ $loan->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-4 text-gray-500 bg-white rounded-lg">
                    No active loans.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Loan History -->
    <div>
        <h2 class="font-bold text-gray-800 text-lg mb-3">Recent History</h2>
        <div class="space-y-2">
            @foreach($historyLoans as $loan)
                 <div class="bg-gray-50 p-3 rounded-lg flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-gray-700">{{ $loan->itemUnit->item->name ?? 'Unknown Item' }}</p>
                        <p class="text-xs text-gray-500">{{ $loan->loan_date->format('d/m/y') }}</p>
                    </div>
                    <span class="text-xs text-gray-500">{{ ucfirst($loan->status) }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
