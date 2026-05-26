<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use App\Models\PrintRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    protected $listeners = ['refreshWidgets' => '$refresh'];

    protected function getStats(): array
    {
        return [
            Stat::make('Antrean Booking Siswa', Loan::where('status', 'pending')->count())
                ->description('Menunggu verifikasi fisik barang')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Barang Sedang Dipinjam', Loan::where('status', 'active')->count())
                ->description('Sedang dalam sirkulasi peminjaman aktif')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('info'),

            Stat::make('Antrean Jasa Print', PrintRequest::where('status', 'pending')->count())
                ->description('Menunggu proses cetak dokumen')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
        ];
    }
}
