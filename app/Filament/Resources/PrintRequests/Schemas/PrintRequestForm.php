<?php

namespace App\Filament\Resources\PrintRequests\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PrintRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                FileUpload::make('file_path')
                    ->label('Upload PDF')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(5120) // 5MB
                    ->directory('print-requests')
                    ->downloadable()
                    ->required(),
                TextInput::make('page_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'completed' => 'Completed',
        ])
                    ->default('pending')
                    ->required(),
                Textarea::make('reason')
                    ->columnSpanFull(),
            ]);
    }
}
