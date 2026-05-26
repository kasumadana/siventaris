<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use App\Models\ItemUnit;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class LatestPendingLoansWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Antrean Booking Siswa (Terbaru)';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Loan::where('status', 'pending')
                    ->with(['user', 'item'])
                    ->latest()
                    ->limit(5)
            )
            ->paginated(false) // Disable pagination as we only show top 5
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Siswa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('item.name')
                    ->label('Barang yang Diminta')
                    ->placeholder('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('loan_date')
                    ->label('Tanggal Booking')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                // Action 1: Serahkan Barang
                Action::make('handover')
                    ->label('Serahkan Barang')
                    ->icon('heroicon-o-check')
                    ->color('warning')
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

                        $this->dispatch('refreshWidgets');
                    }),
            ]);
    }
}
