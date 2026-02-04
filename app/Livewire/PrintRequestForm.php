<?php

namespace App\Livewire;

use App\Models\PrintRequest;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class PrintRequestForm extends Component
{
    use WithFileUploads;

    public $file;
    public $page_count = 0;
    public $reason;

    public function save()
    {
        $this->validate([
            'file' => 'required|file|mimes:pdf|max:5120', // 5MB
            'page_count' => 'required|numeric|min:1',
            'reason' => 'nullable|string|max:500',
        ]);

        $path = $this->file->store('print-requests', 'public');

        PrintRequest::create([
            'user_id' => Auth::id(),
            'file_path' => $path,
            'page_count' => $this->page_count,
            'reason' => $this->reason,
            'status' => 'pending',
        ]);

        session()->flash('message', 'Print request submitted successfully! Please wait for Toolman approval.');
        
        $this->reset(['file', 'page_count', 'reason']);
    }

    public function render()
    {
        return view('livewire.print-request-form');
    }
}
