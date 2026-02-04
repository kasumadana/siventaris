<?php

namespace App\Observers;

use App\Models\Loan;

class LoanObserver
{
    /**
     * Handle the Loan "updated" event.
     * Manages ItemUnit status transitions based on Loan status:
     * - Pending -> Active: Marks unit as 'borrowed'.
     * - Active -> Returned: Marks unit as 'available'.
     */
    public function updated(Loan $loan): void
    {
        // 1. Pending -> Active (Handover)
        if ($loan->isDirty('status') && $loan->status === 'active') {
            if ($loan->itemUnit) {
               $loan->itemUnit->update(['status' => 'borrowed']);
               // Trigger stock sync via ItemUnitObserver
            }
        }

        // 2. Active -> Returned
        if ($loan->isDirty('status') && $loan->status === 'returned') {
            if ($loan->itemUnit) {
                // Determine condition based on return? Default to available for now.
                // Or check if 'return_condition_image' implies something? 
                // Ideally, Toolman should set unit status manually if damaged, but for automation:
                $loan->itemUnit->update(['status' => 'available']);
                
                // Set return_date if not set
                if (! $loan->return_date) {
                    $loan->updateQuietly(['return_date' => now()]);
                }
            }
        }
    }
    
    /**
     * Handle the Loan "created" event.
     */
    public function created(Loan $loan): void
    {
        // If created directly as active
        if ($loan->status === 'active' && $loan->itemUnit) {
            $loan->itemUnit->update(['status' => 'borrowed']);
        }
    }
}
