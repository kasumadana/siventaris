<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Request Print Service</h2>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-lg flex items-center gap-2">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">
        <!-- File Upload -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Upload File (PDF only, max 5MB)</label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:bg-gray-50 transition-colors {{ $errors->has('file') ? 'border-red-500 bg-red-50' : '' }}">
                @if ($file)
                    <div class="flex items-center justify-center gap-2 text-green-600 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $file->getClientOriginalName() }}
                    </div>
                @else
                    <input type="file" wire:model="file" id="file" class="hidden">
                    <label for="file" class="cursor-pointer flex flex-col items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <span class="text-sm text-gray-600">Click to upload or drag and drop</span>
                        <span class="text-xs text-gray-400 mt-1">PDF up to 5MB</span>
                    </label>
                @endif
            </div>
            @error('file') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Page Count (Estimasi)</label>
                <input type="number" wire:model="page_count" min="1" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('page_count') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
            </div>
            
             <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Reason / Notes</label>
                <textarea wire:model="reason" rows="1" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="For Class Project..."></textarea>
                 @error('reason') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-colors shadow-lg shadow-blue-600/20 flex justify-center items-center gap-2">
            <span wire:loading.remove>Submit Request</span>
            <span wire:loading>Uploading...</span>
        </button>
    </form>
</div>
