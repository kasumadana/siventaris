<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
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
                                \Filament\Schemas\Components\Section::make('Informasi Pribadi')
                                    ->schema([
                                        TextInput::make('name')
                                            ->required(),
                                        TextInput::make('email')
                                            ->label('Alamat Email')
                                            ->email()
                                            ->required(),
                                        \Filament\Schemas\Components\Grid::make(2)
                                            ->schema([
                                                Select::make('role')
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
                        \Filament\Schemas\Components\Group::make()
                            ->columnSpan(['lg' => 1])
                            ->schema([
                                \Filament\Schemas\Components\Section::make('Keamanan & Status')
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
