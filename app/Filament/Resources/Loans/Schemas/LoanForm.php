<?php

namespace App\Filament\Resources\Loans\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

use Filament\Schemas\Schema;

class LoanForm
{
    public static function getSchema(): array
    {
        return [
            \Filament\Schemas\Components\Grid::make(3)
                ->schema([
                    \Filament\Schemas\Components\Group::make()
                        ->columnSpan(['lg' => 2])
                        ->schema([
                            \Filament\Schemas\Components\Section::make('Detail Peminjaman')
                                ->schema([
                                    \Filament\Schemas\Components\Grid::make(2)
                                        ->schema([
                                            Select::make('user_id')
                                                ->label('Peminjam (Siswa)')
                                                ->relationship('user', 'name')
                                                ->searchable()
                                                ->preload()
                                                ->required(),
                                            Select::make('item_unit_id')
                                                ->label('Unit Barang (Scan QR)')
                                                ->relationship('itemUnit', 'unit_code', function ($query) {
                                                    // Only show available units or the current unit if editing
                                                    return $query->where('status', 'available')->where('condition', 'good');
                                                })
                                                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->unit_code} - " . $record->item->name)
                                                ->searchable(['unit_code'])
                                                ->preload()
                                                ->live()
                                                ->required(),
                                        ]),
                                    \Filament\Schemas\Components\Grid::make(2)
                                        ->schema([
                                            DateTimePicker::make('loan_date')
                                                ->label('Tanggal Pinjam')
                                                ->required()
                                                ->default(now()),
                                            DateTimePicker::make('due_date')
                                                ->label('Tenggat Waktu')
                                                ->required()
                                                ->default(now()->addDays(3)),
                                        ]),
                                    Textarea::make('notes')
                                        ->label('Catatan Peminjaman')
                                        ->columnSpanFull(),
                                ]),
                        ]),
                    \Filament\Schemas\Components\Group::make()
                        ->columnSpan(['lg' => 1])
                        ->schema([
                            \Filament\Schemas\Components\Section::make('Status & Pengembalian')
                                ->schema([
                                    Select::make('status')
                                        ->options([
                                            'pending' => 'Pending',
                                            'active' => 'Dipinjam (Active)', 
                                            'returned' => 'Dikembalikan (Returned)', 
                                            'overdue' => 'Terlambat (Overdue)'
                                        ])
                                        ->default('active')
                                        ->live()
                                        ->required(),
                                    DateTimePicker::make('return_date')
                                        ->label('Tanggal Kembali'),
                                    FileUpload::make('return_condition_image')
                                        ->label('Foto Kondisi Kembali')
                                        ->image()
                                        ->directory('loans/returns'),
                                ]),
                        ]),
                ]),
        ];
    }
}
