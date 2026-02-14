<?php

namespace App\Filament\Resources\Loans\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;

class LoanForm
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
                            // ── QR SCANNER SECTION ──
                            Section::make('Scan Kartu Siswa')
                                ->icon('heroicon-o-qr-code')
                                ->schema([
                                    TextInput::make('student_nis_scan')
                                        ->label('Scan Kartu Siswa (QR/Barcode)')
                                        ->placeholder('Arahkan scanner ke kartu siswa atau ketik NIS...')
                                        ->helperText('Scan QR/Barcode pada kartu siswa untuk mengisi data peminjam otomatis.')
                                        ->prefixIcon('heroicon-o-qr-code')
                                        ->autofocus()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function (\Filament\Forms\Set $set, \Filament\Forms\Get $get, ?string $state) {
                                            if (blank($state)) {
                                                return;
                                            }

                                            $student = User::where('student_id_number', $state)->first();

                                            if ($student) {
                                                $set('user_id', $student->id);

                                                Notification::make()
                                                    ->title('Siswa Ditemukan')
                                                    ->body("Nama: {$student->name} | Kelas: {$student->class_name}")
                                                    ->success()
                                                    ->send();
                                            } else {
                                                $set('user_id', null);

                                                Notification::make()
                                                    ->title('Siswa Tidak Ditemukan')
                                                    ->body("NIS \"{$state}\" tidak ditemukan di database.")
                                                    ->danger()
                                                    ->send();
                                            }
                                        })
                                        ->dehydrated(false), // Don't save this virtual field
                                ]),

                            Section::make('Detail Peminjaman')
                                ->schema([
                                    Grid::make(2)
                                        ->schema([
                                            Select::make('user_id')
                                                ->label('Peminjam (Siswa)')
                                                ->relationship('user', 'name')
                                                ->searchable()
                                                ->preload()
                                                ->required(),
                                            Select::make('item_unit_id')
                                                ->label('Unit Barang')
                                                ->relationship('itemUnit', 'unit_code', function ($query) {
                                                    return $query->where('status', 'available')->where('condition', 'good');
                                                })
                                                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->unit_code} - " . $record->item->name)
                                                ->searchable(['unit_code'])
                                                ->preload()
                                                ->live()
                                                ->required(),
                                        ]),
                                    Grid::make(2)
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

                    // ── RIGHT COLUMN (1/3 width) ──
                    Group::make()
                        ->columnSpan(['default' => 'full', 'lg' => 1])
                        ->schema([
                            Section::make('Status & Pengembalian')
                                ->schema([
                                    Select::make('status')
                                        ->options([
                                            'pending' => 'Pending',
                                            'active' => 'Dipinjam (Active)',
                                            'returned' => 'Dikembalikan (Returned)',
                                            'overdue' => 'Terlambat (Overdue)',
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
