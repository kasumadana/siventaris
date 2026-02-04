<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Elektronik',
            'Kabel',
            'Alat Berat',
            'ATK',
            'Multimedia',
            'Jaringan',
            'Otomotif',
            'Lain-lain',
        ];

        foreach ($categories as $category) {
            \App\Models\Category::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($category)],
                ['name' => $category]
            );
        }
    }
}
