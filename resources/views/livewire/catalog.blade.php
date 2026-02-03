<div class="space-y-4 pb-20">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Catalog</h1>
        <div class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
           Hi, {{ auth()->user()->name }}
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white p-4 rounded-xl shadow-sm space-y-3">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search items..." class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        
        <div class="flex space-x-2 overflow-x-auto pb-2">
            <button wire:click="$set('category_id', '')" class="px-4 py-1.5 rounded-full text-sm whitespace-nowrap {{ $category_id === '' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600' }}">
                All
            </button>
            @foreach($categories as $category)
                <button wire:click="$set('category_id', {{ $category->id }})" class="px-4 py-1.5 rounded-full text-sm whitespace-nowrap {{ $category_id === $category->id ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600' }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Items Grid -->
    <div class="grid grid-cols-2 gap-4">
        @forelse($items as $item)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
                <div class="h-32 bg-gray-200 flex items-center justify-center">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-gray-400 text-4xl">📷</span>
                    @endif
                </div>
                <div class="p-3 flex-1 flex flex-col">
                    <h3 class="font-bold text-gray-800 truncate">{{ $item->name }}</h3>
                    <p class="text-xs text-gray-500 mb-2">{{ $item->category->name }}</p>
                    
                    <div class="mt-auto flex justify-between items-center">
                        <span class="text-xs font-medium {{ $item->available_stock > 0 ? 'text-green-600' : 'text-red-500' }}">
                            {{ $item->available_stock > 0 ? $item->available_stock . ' Available' : 'Out of Stock' }}
                        </span>
                        
                        @if($item->available_stock > 0)
                            <a href="{{ route('booking', $item->id) }}" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-700">
                                Book
                            </a>
                        @else
                            <button disabled class="bg-gray-300 text-gray-500 px-3 py-1.5 rounded-lg text-xs font-semibold cursor-not-allowed">
                                Book
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-2 text-center py-10 text-gray-500">
                No items found.
            </div>
        @endforelse
    </div>
</div>
