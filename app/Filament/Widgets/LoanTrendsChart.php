<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class LoanTrendsChart extends ChartWidget
{
    protected ?string $heading = 'Tren Peminjaman (7 Hari Terakhir)';
    protected static ?int $sort = 4;
    protected int|string|array $columnSpan = 1;
    protected ?string $maxHeight = '275px';

    protected function getData(): array
    {
        // Simple manual implementation if Trend library is not available
        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('D, d M');
            $data[] = Loan::whereDate('created_at', $date->toDateString())->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pinjaman',
                    'data' => $data,
                    'fill' => 'start',
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
