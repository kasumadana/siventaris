<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'department' => \App\Enums\Department::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function itemUnits(): HasMany
    {
        return $this->hasMany(ItemUnit::class);
    }

    public function getAvailableStockAttribute()
    {
        return $this->total_stock;
    }

    /**
     * Sync the total stock based on available units.
     * This method is called by ItemUnitObserver whenever a unit is modified.
     */
    public function syncStock(): void
    {
        $this->update([
            'total_stock' => $this->itemUnits()->where('status', 'available')->count(),
        ]);
    }
}
