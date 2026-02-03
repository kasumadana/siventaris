<div class="bg-white p-8 rounded-2xl shadow-lg">
    <div class="text-center mb-8">
        <img src="{{ asset('images/logo.png') }}" alt="SIVENTARIS Logo" class="h-12 mx-auto mb-2">
        <p class="text-gray-500 text-sm">Student Inventory System</p>
    </div>

    <form wire:submit="login" class="space-y-5">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input wire:model="email" type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input wire:model="password" type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg shadow transition duration-200">
            Sign In
        </button>

        <div class="text-center mt-4">
            <span class="text-xs text-gray-400">Don't have an account? </span>
            <span class="text-xs text-blue-500">Contact Admin</span>
        </div>
    </form>
</div>
