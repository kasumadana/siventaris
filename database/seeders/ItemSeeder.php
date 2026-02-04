<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = \App\Models\Category::all();
        $departments = \App\Enums\Department::cases();

        if ($categories->isEmpty()) {
            $this->command->error('Please run CategorySeeder first.');
            return;
        }

        $items = [
            'RPL' => [
                'Laptop Lenovo ThinkPad', 'Proyektor Epson', 'Kabel VGA 5m', 'Arduino Uno Kit', 'Raspberry Pi 4'
            ],
            'TKJ' => [
                'Router Mikrotik', 'Switch Cisco 24 Port', 'Tang Crimping', 'LAN Tester', 'Access Point Ubiquiti'
            ],
            'MM' => [ // Mapping MM to DKV or similar if intended, but let's stick to generic or correct enums
                'Kamera Canon DSLR', 'Tripod Takara', 'Lighting Studio Setup', 'Green Screen'
            ],
            'General' => [
                'Kabel HDMI', 'Stop Kontak 5 Lubang', 'Mouse Wireless', 'Keyboard Logitech'
            ]
        ];

        foreach ($departments as $dept) {
            // Pick a set of items based on dept name similarity or random
            $deptName = $dept->value;
            $itemList = $items[$deptName] ?? $items['General']; // Fallback to general if specific list not found

            foreach ($itemList as $itemName) {
                // Find or create category based on item name keywords
                $category = $categories->random(); // Fallback
                if (str_contains($itemName, 'Kabel') || str_contains($itemName, 'VGA')) $category = $categories->where('name', 'Kabel')->first() ?? $category;
                if (str_contains($itemName, 'Laptop') || str_contains($itemName, 'Arduino') || str_contains($itemName, 'Pi')) $category = $categories->where('name', 'Elektronik')->first() ?? $category;
                if (str_contains($itemName, 'Kamera') || str_contains($itemName, 'Tripod')) $category = $categories->where('name', 'Multimedia')->first() ?? $category;
                if (str_contains($itemName, 'Router') || str_contains($itemName, 'Switch')) $category = $categories->where('name', 'Jaringan')->first() ?? $category;

                $item = \App\Models\Item::firstOrCreate([
                    'slug' => \Illuminate\Support\Str::slug($itemName . '-' . $deptName),
                ], [
                    'name' => $itemName . ' (' . $deptName . ')',
                    'category_id' => $category->id,
                    'department' => $dept,
                    'description' => 'Inventaris resmi milik jurusan ' . $dept->getLabel(),
                    'total_stock' => 0, // Will be updated by observer
                ]);

                // Create Item Units if not exists
                if ($item->itemUnits()->count() === 0) {
                    $units = [];
                    for ($i = 1; $i <= rand(3, 8); $i++) {
                        $units[] = new \App\Models\ItemUnit([
                            'unit_code' => strtoupper($deptName) . '-' . substr(str_replace(' ', '', $itemName), 0, 3) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                            'condition' => 'good',
                            'status' => 'available',
                        ]);
                    }
                    $item->itemUnits()->saveMany($units);
                    
                    // Manually sync just in case observer doesn't fire on saveMany (it typically fires on model events, saveMany might batch or not fire 'created' on parent)
                    // Actually, ItemUnitObserver listens to ItemUnit events. saveMany fires 'save' for each model instance loop internally in eloquent usually.
                    // But safe bet is to sync once.
                    $item->syncStock();
                }
            }
        }
    }
}
