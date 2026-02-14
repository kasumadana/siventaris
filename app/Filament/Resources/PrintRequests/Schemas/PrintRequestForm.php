<?php

namespace App\Filament\Resources\PrintRequests\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;



use Filament\Schemas\Schema;

class PrintRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Grid::make(3)
                    ->schema([
                        \Filament\Schemas\Components\Group::make()
                            ->columnSpan(['lg' => 2])
                            ->schema([
                                \Filament\Schemas\Components\Section::make('Informasi Request Print')
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
                        \Filament\Schemas\Components\Group::make()
                            ->columnSpan(['lg' => 1])
                            ->schema([
                                \Filament\Schemas\Components\Section::make('Parameter & Status')
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
