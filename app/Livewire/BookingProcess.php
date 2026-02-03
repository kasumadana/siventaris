<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.app')]
class BookingProcess extends Component
{
    public Item $item;

    #[Rule('required|date|after:now')]
    public $pick_up_date;

    #[Rule('required|integer|min:1|max:7')]
    public $duration = 3; // days

    public function mount(Item $item)
    {
        $this->item = $item;
        $this->pick_up_date = now()->format('Y-m-d\TH:i');
    }

    public function book()
    {
        $this->validate();

        $user = Auth::user();

        // 1. Check Sanctions
        if ($user->hasActiveSanction()) {
            session()->flash('error', 'You have active sanctions or overdue loans.');
            return;
        }

        // 2. Check Stock Availability
        $availableStock = $this->item->itemUnits()->where('status', 'available')->count();
        if ($availableStock <= 0) {
            session()->flash('error', 'Item is out of stock.');
            return;
        }

        // 3. Create Pending Loan
        Loan::create([
            'user_id' => $user->id,
            'item_unit_id' => null, // Will be assigned by Toolman
            'loan_date' => $this->pick_up_date,
            'due_date' => \Carbon\Carbon::parse($this->pick_up_date)->addDays($this->duration),
            'status' => 'pending',
        ]);

        session()->flash('message', 'Booking request submitted! Please visit the Toolman to pick up your item.');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.booking-process');
    }
}
