<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Item;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Catalog extends Component
{
    public $search = '';
    public $category_id = '';
    public $department = '';

    public function render()
    {
        $categories = Category::all();

        $items = Item::with('itemUnits')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->category_id, function ($query) {
                $query->where('category_id', $this->category_id);
            })
            ->when($this->department, function ($query) {
                $query->where('department', $this->department);
            })
            ->get()
            ->map(function ($item) {
                // Calculate available stock dynamically
                $item->available_stock = $item->itemUnits->where('status', 'available')->count();
                return $item;
            });

        return view('livewire.catalog', [
            'items' => $items,
            'categories' => $categories
        ]);
    }
}
