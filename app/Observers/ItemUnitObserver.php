<?php

namespace App\Observers;

use App\Models\ItemUnit;

class ItemUnitObserver
{
    /**
     * Handle the ItemUnit "created" event.
     */
    public function created(ItemUnit $itemUnit): void
    {
        $itemUnit->item->syncStock();
    }

    /**
     * Handle the ItemUnit "updated" event.
     * Decrements or increments Item stock if status changes (e.g. available -> lost).
     */
    public function updated(ItemUnit $itemUnit): void
    {
        if ($itemUnit->isDirty('status') || $itemUnit->isDirty('condition')) {
            $itemUnit->item->syncStock();
        }
    }

    /**
     * Handle the ItemUnit "deleted" event.
     */
    public function deleted(ItemUnit $itemUnit): void
    {
        $itemUnit->item->syncStock();
    }

    /**
     * Handle the ItemUnit "restored" event.
     */
    public function restored(ItemUnit $itemUnit): void
    {
        $itemUnit->item->syncStock();
    }

    /**
     * Handle the ItemUnit "force deleted" event.
     */
    public function forceDeleted(ItemUnit $itemUnit): void
    {
        $itemUnit->item->syncStock();
    }
}
