<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalUsersWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        try {
            $stats = User::getStats();
            $cards = [
                Stat::make('Total User', $stats['total'])
                    ->description($stats['increase'] . '% peningkatan')
                    ->descriptionIcon('heroicon-m-user-group')
                    ->chart([4, 7, 8, 10, 12, 15, $stats['total']])
                    ->color('success'),
            ];

            // Role-based stats
            $roleColors = [
                'Super Admin' => 'danger',
                'Admin' => 'warning',
                'Sekbid' => 'indigo',
                'Pengunjung' => 'info'
            ];

            foreach ($roleColors as $role => $color) {
                if (isset($stats[$role])) {
                    $cards[] = Stat::make($role, $stats[$role])
                        ->description('Total ' . $role)
                        ->descriptionIcon('heroicon-m-shield-check')
                        ->chart([2, 3, 3, 4, 4, 5, $stats[$role]])
                        ->color($color);
                }
            }

            return $cards;

        } catch (\Exception $e) {
            report($e);
            
            return [
                Stat::make('Total User', 0)
                    ->description('Error loading stats')
                    ->descriptionIcon('heroicon-m-exclamation-circle')
                    ->color('danger'),
            ];
        }
    }
}
