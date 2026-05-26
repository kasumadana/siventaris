<?php

namespace App\Filament\Resources\Loans\Tables;

use App\Models\Loan;
use App\Models\ItemUnit;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class LoansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Peminjam')
                    ->searchable(),
                TextColumn::make('item.name')
                    ->label('Barang yang Diminta')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('itemUnit.unit_code')
                    ->label('Kode Unit Fisik')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('loan_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('due_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('return_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                ImageColumn::make('return_condition_image'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordUrl(null) // Disables clicking row to navigate to edit page
            ->recordActions([
                // Action 1: Serahkan Barang
                Action::make('handover')
                    ->label('Serahkan Barang')
                    ->icon('heroicon-o-check')
                    ->color('warning')
                    ->visible(fn (Loan $record) => $record->status === 'pending')
                    ->form([
                        Placeholder::make('student_nis')
                            ->label('NIS Siswa')
                            ->content(fn (Loan $record) => $record->user->student_id_number ?? '-'),
                        Placeholder::make('requested_item')
                            ->label('Barang yang Diminta')
                            ->content(fn (Loan $record) => $record->item->name ?? '-'),
                        Select::make('item_unit_id')
                            ->label('Pilih Unit Fisik Aset')
                            ->options(fn (Loan $record) => ItemUnit::where('item_id', $record->item_id)
                                ->where('status', 'available')
                                ->where('condition', 'good')
                                ->pluck('unit_code', 'id')
                            )
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])
                    ->action(function (Loan $record, array $data) {
                        DB::transaction(function () use ($record, $data) {
                            $itemUnit = ItemUnit::findOrFail($data['item_unit_id']);
                            
                            $record->update([
                                'item_unit_id' => $itemUnit->id,
                                'status' => 'active',
                                'loan_date' => now(), // Set to actual handover time
                            ]);
                            
                            // LoanObserver handles setting itemUnit status to 'borrowed' automatically!
                        });

                        Notification::make()
                            ->title('Barang berhasil diserahkan!')
                            ->success()
                            ->send();
                    }),

                // Action 2: Selesai / Kembalikan
                Action::make('return')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
                    ->visible(fn (Loan $record) => $record->status === 'active')
                    ->requiresConfirmation()
                    ->action(function (Loan $record) {
                        DB::transaction(function () use ($record) {
                            $record->update([
                                'status' => 'returned',
                            ]);
                            
                            // LoanObserver handles setting return_date, itemUnit status to 'available', and syncStock!
                        });

                        Notification::make()
                            ->title('Barang berhasil dikembalikan!')
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
