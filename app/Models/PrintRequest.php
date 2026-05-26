<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrintRequest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::saving(function (PrintRequest $printRequest) {
            // Auto-detect PDF page count if file_path is set and dirty (newly uploaded)
            if ($printRequest->isDirty('file_path') && $printRequest->file_path) {
                $fullPath = storage_path('app/public/' . $printRequest->file_path);
                
                if (file_exists($fullPath)) {
                    $content = @file_get_contents($fullPath);
                    if ($content) {
                        $pageCount = 0;
                        
                        // Parse /Count in the PDF raw stream
                        if (preg_match('/\/Count\s+(\d+)/', $content, $matches)) {
                            $pageCount = (int) $matches[1];
                        } elseif (preg_match('/\/Count\s*\[?\s*(\d+)/', $content, $matches)) {
                            $pageCount = (int) $matches[1];
                        }
                        
                        if ($pageCount > 0) {
                            $printRequest->page_count = $pageCount;
                        }
                    }
                }
            }

            // Auto-fill total price based on Rp 500 rate
            $printRequest->total_price = ($printRequest->page_count ?? 0) * 500;
        });
    }
}
