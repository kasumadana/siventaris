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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function itemUnits(): HasMany
    {
        return $this->hasMany(ItemUnit::class);
    }

    /**
     * Sync the total stock based on available units.
     */
    public function syncStock(): void
    {
        $this->update([
            'total_stock' => $this->itemUnits()->where('status', 'available')->count(),
        ]);
    }
}
