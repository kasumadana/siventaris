<?php

namespace App\Filament\Imports;

use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Number;

class UserImporter extends Importer
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('email')
                ->requiredMapping()
                ->rules(['required', 'email', 'max:255']),
            ImportColumn::make('password')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->fillRecordUsing(function (User $record, string $state) {
                    // Auto-hash the password on import
                    $record->password = Hash::make($state);
                }),
            ImportColumn::make('role')
                ->requiredMapping()
                ->rules(['required', 'in:admin,toolman,student']),
            ImportColumn::make('class_name')
                ->rules(['max:255']),
            ImportColumn::make('student_id_number')
                ->rules(['max:255']),
            ImportColumn::make('is_blocked')
                ->boolean()
                ->rules(['boolean'])
                ->fillRecordUsing(function (User $record, ?string $state) {
                    $record->is_blocked = filter_var($state ?? false, FILTER_VALIDATE_BOOLEAN);
                }),
        ];
    }

    public function resolveRecord(): User
    {
        return new User();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Import user selesai dan ' . Number::format($import->successful_rows) . ' ' . str('baris')->plural($import->successful_rows) . ' berhasil diimport.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal diimport.';
        }

        return $body;
    }
}
