<?php

namespace App\Filament\Resources\PrintRequests\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PrintRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ROOT GRID: 3 columns
                Grid::make(['default' => 1, 'lg' => 3])
                    ->schema([
                        // ── LEFT COLUMN (2/3 width) ──
                        Group::make()
                            ->columnSpan(['default' => 'full', 'lg' => 2])
                            ->schema([
                                Section::make('Informasi Request Print')
                                    ->schema([
                                        Select::make('user_id')
                                            ->label('User (Pemohon)')
                                            ->relationship('user', 'name')
                                            ->required()
                                            ->searchable()
                                            ->preload(),
                                        FileUpload::make('file_path')
                                            ->label('File PDF')
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->maxSize(5120) // 5MB
                                            ->directory('print-requests')
                                            ->downloadable()
                                            ->required()
                                            ->columnSpanFull(),
                                        Textarea::make('reason')
                                            ->label('Alasan / Keterangan')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // ── RIGHT COLUMN (1/3 width) ──
                        Group::make()
                            ->columnSpan(['default' => 'full', 'lg' => 1])
                            ->schema([
                                Section::make('Parameter & Status')
                                    ->schema([
                                        Select::make('status')
                                            ->options([
                                                'pending' => 'Pending',
                                                'approved' => 'Disetujui',
                                                'rejected' => 'Ditolak',
                                                'completed' => 'Selesai',
                                            ])
                                            ->default('pending')
                                            ->required(),
                                        TextInput::make('page_count')
                                            ->label('Jumlah Halaman')
                                            ->required()
                                            ->numeric()
                                            ->default(0),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
