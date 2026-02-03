<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemUnit extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Check if unit is available for loan
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available' && $this->condition === 'good';
    }
}
