<?php

namespace App\Filament\Resources\Items\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;

class ItemForm
{
    public static function getSchema(): array
    {
        return [
            // ROOT GRID: 3 columns
            Grid::make(['default' => 1, 'lg' => 3])
                ->schema([
                    // ── LEFT COLUMN (2/3 width) ──
                    Group::make()
                        ->columnSpan(['default' => 'full', 'lg' => 2])
                        ->schema([
                            Section::make('Informasi Utama Barang')
                                ->columns(2)
                                ->schema([
                                    TextInput::make('name')
                                        ->label('Nama Barang')
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (\Filament\Forms\Set $set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                    TextInput::make('slug')
                                        ->required()
                                        ->unique(ignoreRecord: true),
                                    Select::make('department')
                                        ->label('Departemen')
                                        ->options(\App\Enums\Department::class)
                                        ->searchable()
                                        ->required(),
                                    Select::make('category_id')
                                        ->label('Kategori')
                                        ->relationship('category', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->createOptionForm([
                                            TextInput::make('name')
                                                ->required(),
                                            TextInput::make('slug')
                                                ->required(),
                                        ])
                                        ->required(),
                                ]),

                            Section::make('Unit Inventaris (Stok)')
                                ->schema([
                                    Repeater::make('itemUnits')
                                        ->relationship()
                                        ->schema([
                                            TextInput::make('unit_code')
                                                ->label('Kode Unit')
                                                ->required()
                                                ->unique(ignoreRecord: true),
                                            Select::make('condition')
                                                ->label('Kondisi')
                                                ->options([
                                                    'good' => 'Baik',
                                                    'damaged' => 'Rusak',
                                                    'lost' => 'Hilang',
                                                ])
                                                ->default('good')
                                                ->required(),
                                            Select::make('status')
                                                ->options([
                                                    'available' => 'Tersedia',
                                                    'borrowed' => 'Dipinjam',
                                                    'maintenance' => 'Perbaikan',
                                                ])
                                                ->default('available')
                                                ->required(),
                                        ])
                                        ->columns(3)
                                        ->defaultItems(1)
                                        ->addActionLabel('Tambah Unit Baru'),
                                    Placeholder::make('total_stock_display')
                                        ->label('Estimasi Stok')
                                        ->content(fn ($get) => count($get('itemUnits') ?? []) . ' unit akan dibuat/disimpan'),
                                ]),
                        ]),

                    // ── RIGHT COLUMN (1/3 width) ──
                    Group::make()
                        ->columnSpan(['default' => 'full', 'lg' => 1])
                        ->schema([
                            Section::make('Gambar Barang')
                                ->schema([
                                    FileUpload::make('image')
                                        ->label('Upload Gambar')
                                        ->image()
                                        ->directory('items')
                                        ->imageEditor(),
                                ]),
                            Section::make('Deskripsi')
                                ->schema([
                                    Textarea::make('description')
                                        ->label('Deskripsi Barang')
                                        ->rows(5)
                                        ->columnSpanFull(),
                                ]),
                        ]),
                ]),
        ];
    }
}
