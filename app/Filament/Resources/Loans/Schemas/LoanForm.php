<?php

namespace App\Filament\Resources\Loans\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LoanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('item_unit_id')
                    ->label('Scan Item (QR Code)')
                    ->relationship('itemUnit', 'unit_code')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->unit_code} - " . $record->item->name)
                    ->searchable(['unit_code'])
                    ->preload()
                    ->required(),
                DateTimePicker::make('loan_date')
                    ->required(),
                DateTimePicker::make('due_date')
                    ->required(),
                DateTimePicker::make('return_date'),
                Select::make('status')
                    ->options(['active' => 'Active', 'returned' => 'Returned', 'overdue' => 'Overdue'])
                    ->default('active')
                    ->required(),
                FileUpload::make('return_condition_image')
                    ->image(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
