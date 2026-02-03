<div class="space-y-6 pb-20">
    <div class="flex items-center space-x-2">
        <a href="{{ route('catalog') }}" class="text-gray-500 hover:text-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-xl font-bold text-gray-800">Book Item</h1>
    </div>

    <!-- Item Details -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="h-48 bg-gray-200 flex items-center justify-center">
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover">
            @else
                <span class="text-gray-400 text-6xl">📷</span>
            @endif
        </div>
        <div class="p-4">
            <h2 class="text-2xl font-bold text-gray-800">{{ $item->name }}</h2>
            <div class="flex items-center space-x-2 mt-1 mb-4">
                 <span class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded-full">{{ $item->category->name }}</span>
            </div>
            <p class="text-gray-600 text-sm leading-relaxed">
                {{ $item->description ?? 'No description available for this item.' }}
            </p>
        </div>
    </div>

    <!-- Booking Form -->
    <div class="bg-white p-6 rounded-xl shadow-sm">
        <h3 class="font-bold text-lg mb-4">Selection Details</h3>
        
        <form wire:submit="book" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pick-up Date</label>
                <input wire:model="pick_up_date" type="datetime-local" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                @error('pick_up_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                 <label class="block text-sm font-medium text-gray-700 mb-1">Duration (Days)</label>
                 <select wire:model="duration" class="w-full border-gray-300 rounded-lg focus:ring-blue-500">
                     @foreach(range(1, 7) as $day)
                        <option value="{{ $day }}">{{ $day }} Day(s)</option>
                     @endforeach
                 </select>
                 @error('duration') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            @if (session()->has('error'))
                <div class="p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg shadow-md hover:bg-blue-700 transition">
                Confirm Booking
            </button>
        </form>
    </div>
</div>
