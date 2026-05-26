<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use App\Models\PrintRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Peminjaman Pending', Loan::where('status', 'pending')->count())
                ->description('Peminjaman yang menunggu persetujuan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Peminjaman Aktif', Loan::where('status', 'active')->count())
                ->description('Peminjaman yang sedang berlangsung')
                ->descriptionIcon('heroicon-m-play')
                ->color('info'),

            Stat::make('Antrean E-Print', PrintRequest::where('status', 'pending')->count())
                ->description('Permintaan print yang belum diproses')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
        ];
    }
}
