<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
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
                                Section::make('Informasi Pribadi')
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nama Lengkap')
                                            ->required(),
                                        TextInput::make('email')
                                            ->label('Alamat Email')
                                            ->email()
                                            ->required(),
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('role')
                                                    ->label('Peran')
                                                    ->options([
                                                        'admin' => 'Admin',
                                                        'toolman' => 'Toolman',
                                                        'student' => 'Siswa',
                                                    ])
                                                    ->default('student')
                                                    ->required(),
                                                TextInput::make('student_id_number')
                                                    ->label('NIS / NIP'),
                                                TextInput::make('class_name')
                                                    ->label('Kelas (Jika Siswa)'),
                                            ]),
                                    ]),
                            ]),

                        // ── RIGHT COLUMN (1/3 width) ──
                        Group::make()
                            ->columnSpan(['default' => 'full', 'lg' => 1])
                            ->schema([
                                Section::make('Keamanan & Status')
                                    ->schema([
                                        TextInput::make('password')
                                            ->password()
                                            ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                                            ->dehydrated(fn ($state) => filled($state))
                                            ->required(fn (string $context): bool => $context === 'create'),
                                        DateTimePicker::make('email_verified_at')
                                            ->label('Verifikasi Email'),
                                        Toggle::make('is_blocked')
                                            ->label('Blokir Akun')
                                            ->helperText('User tidak akan bisa login jika diaktifkan.')
                                            ->required(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
