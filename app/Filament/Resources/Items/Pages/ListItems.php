<?php

namespace App\Filament\Resources\Items\Pages;

use App\Filament\Imports\ItemImporter;
use App\Filament\Resources\Items\ItemResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListItems extends ListRecords
{
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->importer(ItemImporter::class)
                ->label('Import Barang')
                ->icon('heroicon-o-arrow-up-tray'),
            CreateAction::make()
                ->label('Tambah Barang'),
        ];
    }
}
