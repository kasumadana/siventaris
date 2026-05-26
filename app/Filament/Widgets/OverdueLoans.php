<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Carbon;

class OverdueLoans extends BaseWidget
{
    protected static ?string $heading = 'Peringatan: Peminjaman Terlambat';
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Loan::query()
                    ->where('status', 'active')
                    ->where('due_date', '<', now())
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Siswa')
                    ->weight('bold')
                    ->color('danger'),
                Tables\Columns\TextColumn::make('item.name')
                    ->label('Barang'),
                Tables\Columns\TextColumn::make('itemUnit.unit_code')
                    ->label('Kode Unit')
                    ->badge(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Tenggat')
                    ->dateTime('d M Y')
                    ->description(fn (Loan $record): string => Carbon::parse($record->due_date)->diffForHumans())
                    ->color('danger'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->default('OVERDUE')
                    ->color('danger'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Lihat Detail')
                    ->url(fn (Loan $record): string => "/admin/loans/{$record->id}/edit")
                    ->icon('heroicon-m-eye')
                    ->button(),
            ]);
    }

    public static function canView(): bool
    {
        return Loan::where('status', 'active')->where('due_date', '<', now())->exists();
    }
}
