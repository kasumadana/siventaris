<?php

namespace App\Filament\Widgets;

use App\Models\ItemUnit;
use Filament\Widgets\ChartWidget;

class ItemUnitStatusChart extends ChartWidget
{
    protected ?string $heading = 'Status Unit Inventaris';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 1;
    protected ?string $maxHeight = '275px';

    protected function getData(): array
    {
        $available = ItemUnit::where('status', 'available')->count();
        $borrowed = ItemUnit::where('status', 'borrowed')->count();
        $maintenance = ItemUnit::where('status', 'maintenance')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Unit Inventaris',
                    'data' => [$available, $borrowed, $maintenance],
                    'backgroundColor' => [
                        '#10b981', // Emerald for available
                        '#3b82f6', // Blue for borrowed
                        '#f59e0b', // Amber for maintenance
                    ],
                ],
            ],
            'labels' => ['Tersedia', 'Dipinjam', 'Perbaikan'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
