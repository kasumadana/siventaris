<?php

namespace App\Filament\Resources\Items;

use App\Filament\Resources\Items\Pages\CreateItem;
use App\Filament\Resources\Items\Pages\EditItem;
use App\Filament\Resources\Items\Pages\ListItems;
use App\Filament\Resources\Items\Schemas\ItemForm;
use App\Filament\Resources\Items\Tables\ItemsTable;
use App\Models\Item;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Grid::make(3)
                    ->schema([
                        // Left Column (2/3)
                        \Filament\Schemas\Components\Group::make()
                            ->columnSpan(['lg' => 2])
                            ->schema([
                                \Filament\Schemas\Components\Section::make('Informasi Utama Barang')
                                    ->schema([
                                        \Filament\Schemas\Components\Grid::make(2)
                                            ->schema([
                                                \Filament\Forms\Components\TextInput::make('name')
                                                    ->required()
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn (\Filament\Forms\Set $set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                                \Filament\Forms\Components\TextInput::make('slug')
                                                    ->required()
                                                    ->unique(ignoreRecord: true),
                                                \Filament\Forms\Components\Select::make('department')
                                                    ->options(\App\Enums\Department::class)
                                                    ->searchable()
                                                    ->required(),
                                                \Filament\Forms\Components\Select::make('category_id')
                                                    ->relationship('category', 'name')
                                                    ->searchable()
                                                    ->preload()
                                                    ->createOptionForm([
                                                        \Filament\Forms\Components\TextInput::make('name')
                                                            ->required(),
                                                        \Filament\Forms\Components\TextInput::make('slug')
                                                            ->required(),
                                                    ])
                                                    ->required(),
                                            ]),
                                    ]),
                                \Filament\Schemas\Components\Section::make('Unit Inventaris (Stok)')
                                    ->schema([
                                        \Filament\Forms\Components\Repeater::make('itemUnits')
                                            ->relationship()
                                            ->schema([
                                                \Filament\Forms\Components\TextInput::make('unit_code')
                                                    ->required()
                                                    ->unique(ignoreRecord: true),
                                                \Filament\Forms\Components\Select::make('condition')
                                                    ->options([
                                                        'good' => 'Good',
                                                        'damaged' => 'Damaged',
                                                        'lost' => 'Lost',
                                                    ])
                                                    ->default('good')
                                                    ->required(),
                                                \Filament\Forms\Components\Select::make('status')
                                                    ->options([
                                                        'available' => 'Available',
                                                        'borrowed' => 'Borrowed',
                                                        'maintenance' => 'Maintenance',
                                                    ])
                                                    ->default('available')
                                                    ->required(),
                                            ])
                                            ->columns(3)
                                            ->defaultItems(1)
                                            ->addActionLabel('Tambah Unit Baru'),
                                        \Filament\Forms\Components\Placeholder::make('total_stock_display')
                                            ->label('Estimasi Stok')
                                            ->content(fn ($get) => count($get('itemUnits') ?? []) . ' unit akan dibuat/disimpan'),
                                    ]),
                            ]),
                        
                        // Right Column (1/3)
                        \Filament\Schemas\Components\Group::make()
                            ->columnSpan(['lg' => 1])
                            ->schema([
                                \Filament\Schemas\Components\Section::make('Gambar Barang')
                                    ->schema([
                                        \Filament\Forms\Components\FileUpload::make('image')
                                            ->image()
                                            ->directory('items')
                                            ->imageEditor(),
                                    ]),
                                \Filament\Schemas\Components\Section::make('Deskripsi')
                                    ->schema([
                                        \Filament\Forms\Components\Textarea::make('description')
                                            ->rows(5)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return ItemsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListItems::route('/'),
            'create' => CreateItem::route('/create'),
            'edit' => EditItem::route('/{record}/edit'),
        ];
    }
}
