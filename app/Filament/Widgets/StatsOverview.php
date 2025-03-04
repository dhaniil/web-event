<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalEvents = Event::count();
        $activeEvents = Event::where('status', 'active')->count();
        $mostVisited = Event::orderBy('visit_count', 'desc')->first();

        return [
            Stat::make('Total Event', $totalEvents)
                ->description('Total Event')
                ->descriptionIcon('heroicon-m-calendar')
                ->chart([7, 4, 6, 8, 5, 9, 10])
                ->color('primary'),

            Stat::make('Total Berita', \App\Models\Berita::count())
                ->description('Total Berita')
                ->descriptionIcon('heroicon-m-newspaper')
                ->chart([7, 4, 6, 8, 5, 9, 10])
                ->color('success'),

            Stat::make('Event paling sering dikunjungi', $mostVisited ? ($mostVisited->visit_count ?? 0) : 0)
                ->description($mostVisited ? ($mostVisited->name ?? 'Tidak ada') : 'Tidak ada')
                ->descriptionIcon('heroicon-m-eye')
                ->chart([8, 12, 15, 14, 18, 16, 20])
                ->color('warning'),
        ];
    }
}
