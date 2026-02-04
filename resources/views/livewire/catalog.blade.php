<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Catalog</h1>
            <p class="text-sm text-gray-500">Explore available tools and equipment.</p>
        </div>
        <div class="px-4 py-1.5 bg-blue-50 border border-blue-100 text-blue-700 rounded-full text-xs font-semibold shadow-sm">
           Hi, {{ auth()->user()->name }}
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 space-y-4">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search for items..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border-transparent focus:bg-white border-2 rounded-xl focus:border-primary focus:ring-0 transition-all text-sm font-medium placeholder-gray-400">
        </div>
        
        <div class="flex space-x-2 overflow-x-auto pb-1 scrollbar-hide">
            <button wire:click="$set('category_id', '')" class="px-5 py-2 rounded-lg text-sm font-medium transition-all {{ $category_id === '' ? 'bg-gray-900 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                All Items
            </button>
            @foreach($categories as $category)
                <button wire:click="$set('category_id', {{ $category->id }})" class="px-5 py-2 rounded-lg text-sm font-medium transition-all whitespace-nowrap {{ $category_id === $category->id ? 'bg-gray-900 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Items Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
        @forelse($items as $item)
            <div class="group bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col h-full">
                <!-- Image -->
                <div class="relative h-36 md:h-48 bg-gray-100 overflow-hidden">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div class="flex items-center justify-center h-full text-gray-300">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <!-- Badge -->
                    <div class="absolute top-3 right-3">
                         <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $item->available_stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                             {{ $item->available_stock > 0 ? 'In Stock' : 'Out' }}
                         </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4 flex-1 flex flex-col">
                    <div class="mb-3">
                        <p class="text-xs text-blue-600 font-semibold uppercase tracking-wide mb-1">{{ $item->category->name }}</p>
                        <h3 class="font-bold text-gray-900 text-lg leading-tight truncate group-hover:text-primary transition-colors">{{ $item->name }}</h3>
                    </div>
                    
                    <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-center">
                         <div class="flex items-center space-x-1 text-gray-500 text-xs">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <span>{{ $item->available_stock }} Units</span>
                        </div>
                        
                        @if($item->available_stock > 0)
                            <a href="{{ route('booking', $item->id) }}" class="bg-gray-900 hover:bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold transition-colors shadow-sm">
                                Book Now
                            </a>
                        @else
                            <button disabled class="bg-gray-100 text-gray-400 px-4 py-2 rounded-lg text-xs font-bold cursor-not-allowed">
                                Unavailable
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                <div class="bg-gray-100 p-4 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">No items found</h3>
                <p class="text-gray-500">Try adjusting your search or filters.</p>
            </div>
        @endforelse
    </div>
</div>
