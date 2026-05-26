<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use App\Models\PrintRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $overdueCount = Loan::where('status', 'active')->where('due_date', '<', now())->count();

        return [
            Stat::make('Peminjaman Pending', Loan::where('status', 'pending')->count())
                ->description('Menunggu persetujuan admin')
                ->descriptionIcon('heroicon-m-clock')
                ->chart([7, 3, 5, 2, 4, 6, 4])
                ->color('warning'),

            Stat::make('Peminjaman Aktif', Loan::where('status', 'active')->count())
                ->description('Barang sedang dipinjam')
                ->descriptionIcon('heroicon-m-play')
                ->chart([2, 10, 5, 2, 3, 14, 10])
                ->color('info'),

            Stat::make('Peminjaman Terlambat', $overdueCount)
                ->description($overdueCount > 0 ? 'Segera tindak lanjuti!' : 'Semua tepat waktu')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($overdueCount > 0 ? 'danger' : 'success'),

            Stat::make('Antrean E-Print', PrintRequest::where('status', 'pending')->count())
                ->description('Belum diproses/cetak')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('emerald'),
        ];
    }
}
