<?php

namespace Tests\Feature;

use App\Models\PrintRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PrintRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_automatically_detects_pdf_page_count_and_calculates_total_price()
    {
        Storage::fake('public');

        // Create a student user
        $student = User::create([
            'name' => 'Test Student',
            'email' => 'student@test.com',
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);

        // Create a mock PDF content with 7 pages (/Count 7)
        $pdfContent = "%PDF-1.4\n1 0 obj\n<< /Type /Pages /Count 7 >>\nendobj\ntrailer\n<< /Root 1 0 R >>\n%%EOF";
        
        $filePath = 'print-requests/test_doc.pdf';
        Storage::disk('public')->put($filePath, $pdfContent);

        // Make sure the file exists in the storage path that storage_path('app/public/') resolves to
        $fullPath = storage_path('app/public/' . $filePath);
        @mkdir(dirname($fullPath), 0777, true);
        file_put_contents($fullPath, $pdfContent);

        // Create Print Request
        $printRequest = PrintRequest::create([
            'user_id' => $student->id,
            'file_path' => $filePath,
            'page_count' => 0, // initially 0
            'status' => 'pending',
        ]);

        // Clean up physical file
        @unlink($fullPath);

        // Assert page count is detected as 7 and total price is 3500 (7 * Rp 500)
        $this->assertEquals(7, $printRequest->page_count);
        $this->assertEquals(3500, $printRequest->total_price);
    }
}
