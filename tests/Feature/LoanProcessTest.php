<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\ItemUnit;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanProcessTest extends TestCase
{
    use RefreshDatabase;

    public function test_loan_booking_and_handover_process()
    {
        // 1. Create Student and Category
        $student = User::create([
            'name' => 'John Doe Student',
            'email' => 'student@sekolah.sch.id',
            'password' => bcrypt('password'),
            'role' => 'student',
            'student_id_number' => 'NIS-8888',
        ]);

        $category = Category::create([
            'name' => 'Elektronik',
            'slug' => 'elektronik',
        ]);

        // 2. Create Item and Units
        $item = Item::create([
            'name' => 'Kamera Canon DSLR',
            'slug' => 'kamera-canon-dslr',
            'category_id' => $category->id,
            'department' => \App\Enums\Department::DKV,
            'total_stock' => 0,
        ]);

        $unit = ItemUnit::create([
            'item_id' => $item->id,
            'unit_code' => 'MM-CAM-001',
            'condition' => 'good',
            'status' => 'available',
        ]);

        // Verify initial total stock is synced via ItemUnitObserver
        $item->refresh();
        $this->assertEquals(1, $item->total_stock);

        // 3. Create Pending Loan (as done in BookingProcess)
        $loan = Loan::create([
            'user_id' => $student->id,
            'item_id' => $item->id,
            'item_unit_id' => null,
            'loan_date' => now(),
            'due_date' => now()->addDays(3),
            'status' => 'pending',
        ]);

        $this->assertEquals('pending', $loan->status);
        $this->assertNull($loan->item_unit_id);
        $this->assertEquals($item->id, $loan->item_id);

        // 4. Simulate Handover (Toolman assigns item unit and activates loan)
        $loan->update([
            'item_unit_id' => $unit->id,
            'status' => 'active',
        ]);

        // Check if LoanObserver automatically marked unit as borrowed and synced stock
        $unit->refresh();
        $item->refresh();
        $this->assertEquals('borrowed', $unit->status);
        $this->assertEquals(0, $item->total_stock);

        // 5. Simulate Return (Toolman returns loan)
        $loan->update([
            'status' => 'returned',
        ]);

        // Check if LoanObserver automatically marked unit as available and synced stock
        $unit->refresh();
        $item->refresh();
        $this->assertEquals('available', $unit->status);
        $this->assertEquals(1, $item->total_stock);
    }
}
