<?php

namespace App\Services;

use App\Models\ItemUnit;
use App\Models\Loan;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class LoanService
{
    /**
     * Create a new loan for a user.
     *
     * @param User $user
     * @param string $itemUnitCode OR $itemUnitId
     * @param int $durationDays
     * @return Loan
     * @throws Exception
     */
    public function createLoan(User $user, $identifier, int $durationDays = 7)
    {
        // 1. Check User Sanctions
        if ($user->hasActiveSanction()) {
            throw new Exception("User cannot borrow items due to active sanctions or overdue loans.");
        }

        // 2. Find Item Unit
        $itemUnit = ItemUnit::where('unit_code', $identifier)
            ->orWhere('id', $identifier)
            ->first();

        if (!$itemUnit) {
            throw new Exception("Item unit not found.");
        }

        // 3. Check Availability
        if (!$itemUnit->isAvailable()) {
            throw new Exception("Item unit is currently unavailable (Status: {$itemUnit->status}, Condition: {$itemUnit->condition}).");
        }

        return DB::transaction(function () use ($user, $itemUnit, $durationDays) {
            // 4. Create Loan Record
            $loan = Loan::create([
                'user_id' => $user->id,
                'item_unit_id' => $itemUnit->id,
                'loan_date' => now(),
                'due_date' => now()->addDays($durationDays),
                'status' => 'active',
            ]);

            // 5. Update Item Status
            $itemUnit->update(['status' => 'borrowed']);

            // 6. Sync Stock Count on Parent Item
            $itemUnit->item->syncStock();

            return $loan;
        });
    }

    /**
     * Return a loan.
     */
    public function returnLoan(Loan $loan, string $condition = 'good', ?string $notes = null)
    {
        return DB::transaction(function () use ($loan, $condition, $notes) {
            $loan->update([
                'return_date' => now(),
                'status' => 'returned',
                'notes' => $notes,
            ]);

            $itemUnit = $loan->itemUnit;
            $itemUnit->update([
                'status' => 'available',
                'condition' => $condition
            ]);

            $itemUnit->item->syncStock();

            return $loan;
        });
    }
}
