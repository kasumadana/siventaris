<?php

namespace App\Filament\Imports;

use App\Models\Item;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class ItemImporter extends Importer
{
    protected static ?string $model = Item::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('slug')
                ->rules(['max:255'])
                ->fillRecordUsing(function (Item $record, string $state) {
                    $record->slug = filled($state) ? $state : Str::slug($record->name);
                }),
            ImportColumn::make('category')
                ->requiredMapping()
                ->relationship()
                ->rules(['required']),
            ImportColumn::make('department')
                ->rules(['max:255']),
            ImportColumn::make('description'),
            ImportColumn::make('image')
                ->rules(['max:255']),
            ImportColumn::make('total_stock')
                ->numeric()
                ->rules(['integer'])
                ->fillRecordUsing(function (Item $record, ?string $state) {
                    $record->total_stock = $state ?? 0;
                }),
        ];
    }

    public function resolveRecord(): Item
    {
        return new Item();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Import barang selesai dan ' . Number::format($import->successful_rows) . ' ' . str('baris')->plural($import->successful_rows) . ' berhasil diimport.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal diimport.';
        }

        return $body;
    }
}
