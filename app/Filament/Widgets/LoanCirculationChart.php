<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class LoanCirculationChart extends ChartWidget
{
    protected $listeners = ['refreshWidgets' => '$refresh'];

    protected ?string $heading = 'Sirkulasi Transaksi Peminjaman (7 Hari Terakhir)';
    
    protected string $color = 'info';

    protected static bool $isLazy = true;

    protected function getData(): array
    {
        // Get counts for the last 7 days
        $data = collect(range(6, 0))->mapWithKeys(function ($daysAgo) {
            $date = Carbon::now()->subDays($daysAgo)->toDateString();
            $count = Loan::whereDate('created_at', $date)->count();
            
            // Format label: Day Name, Date (e.g. Senin, 26 Mei)
            $label = Carbon::parse($date)->translatedFormat('l, d M');
            
            return [$label => $count];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Transaksi Peminjaman',
                    'data' => $data->values()->toArray(),
                    'fill' => 'start',
                ],
            ],
            'labels' => $data->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
