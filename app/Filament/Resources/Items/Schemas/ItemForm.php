<?php

namespace App\Filament\Resources\Items\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class ItemForm
{
    public static function getSchema(): array
    {
        return [
            \Filament\Schemas\Components\Grid::make(3)
                ->schema([
                    \Filament\Schemas\Components\Group::make()
                        ->columnSpan(['lg' => 2])
                        ->schema([
                            Section::make('General Information')
                                ->columns(2)
                                ->schema([
                                    Select::make('department')
                                        ->options(\App\Enums\Department::class)
                                        ->searchable()
                                        ->required(),
                                    Select::make('category_id')
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
                                    TextInput::make('name')
                                        ->required()
                                        ->columnSpanFull(),
                                    TextInput::make('slug')
                                        ->required()
                                        ->unique(ignoreRecord: true)
                                        ->columnSpanFull(),
                                ]),
                            Section::make('Attributes')
                                ->schema([
                                    \Filament\Forms\Components\Repeater::make('itemUnits')
                                        ->relationship()
                                        ->schema([
                                            TextInput::make('unit_code')
                                                ->required()
                                                ->unique(ignoreRecord: true),
                                            Select::make('condition')
                                                ->options([
                                                    'good' => 'Good',
                                                    'damaged' => 'Damaged',
                                                    'lost' => 'Lost',
                                                ])
                                                ->default('good')
                                                ->required(),
                                            Select::make('status')
                                                ->options([
                                                    'available' => 'Available',
                                                    'borrowed' => 'Borrowed',
                                                    'maintenance' => 'Maintenance',
                                                ])
                                                ->default('available')
                                                ->required(),
                                        ])
                                        ->columnSpanFull()
                                        ->grid(2)
                                        ->defaultItems(1)
                                        ->addActionLabel('Add New Unit'),
                                    \Filament\Forms\Components\Placeholder::make('total_stock_display')
                                        ->label('Estimated Stock')
                                        ->content(fn ($get) => count($get('itemUnits') ?? []) . ' Units will be created'),
                                ]),
                        ]),
                    \Filament\Schemas\Components\Group::make()
                        ->columnSpan(['lg' => 1])
                        ->schema([
                            Section::make('Media & Description')
                                ->schema([
                                    FileUpload::make('image')
                                        ->image()
                                        ->directory('items'),
                                    Textarea::make('description')
                                        ->rows(5)
                                        ->columnSpanFull(),
                                ]),
                        ]),
                ]),
        ];
    }
}
