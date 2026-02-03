<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class StudentDashboard extends Component
{
    public function getQrCodeProperty()
    {
        // QR contains User ID (e.g., "USER-1")
        $data = 'USER-' . Auth::id(); 
        return QrCode::size(200)->generate($data);
    }

    public function render()
    {
        $user = Auth::user();
        
        $activeLoans = $user->loans()
            ->with('itemUnit.item')
            ->whereIn('status', ['active', 'pending'])
            ->orderBy('due_date')
            ->get();

        $historyLoans = $user->loans()
            ->with('itemUnit.item')
            ->whereIn('status', ['returned', 'overdue'])
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.student-dashboard', [
            'qrCode' => $this->qrCode,
            'activeLoans' => $activeLoans,
            'historyLoans' => $historyLoans,
        ]);
    }
}
