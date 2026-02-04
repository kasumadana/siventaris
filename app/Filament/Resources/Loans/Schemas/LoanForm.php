<?php

namespace App\Filament\Resources\Loans\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

class LoanForm
{
    public static function getSchema(): array
    {
        return [
            Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->preload()
                ->required(),
            Select::make('item_unit_id')
                ->label('Scan Item (QR Code)')
                ->relationship('itemUnit', 'unit_code', function ($query) {
                    return $query->where('status', 'available')->where('condition', 'good');
                })
                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->unit_code} - " . $record->item->name)
                ->searchable(['unit_code'])
                ->preload()
                ->live()
                ->required(fn ($get) => in_array($get('status'), ['active', 'returned', 'overdue'])),
            DateTimePicker::make('loan_date')
                ->required()
                ->default(now()),
            DateTimePicker::make('due_date')
                ->required()
                ->default(now()->addDays(3)),
            DateTimePicker::make('return_date'),
            Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'active' => 'Active', 
                    'returned' => 'Returned', 
                    'overdue' => 'Overdue'
                ])
                ->default('active')
                ->live()
                ->required(),
            FileUpload::make('return_condition_image')
                ->image()
                ->directory('loans/returns'),
            Textarea::make('notes')
                ->columnSpanFull(),
        ];
    }
}
