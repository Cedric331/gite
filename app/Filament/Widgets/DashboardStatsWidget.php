<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\Reservation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Calcul du taux d'occupation du mois courant
        $daysInMonth = now()->daysInMonth;
        $occupiedDates = Reservation::active()
            ->where(function ($q) {
                $q->whereMonth('start_date', now()->month)
                  ->whereYear('start_date', now()->year);
            })
            ->orWhere(function ($q) {
                $q->whereMonth('end_date', now()->month)
                  ->whereYear('end_date', now()->year)
                  ->active();
            })
            ->get()
            ->flatMap(function ($r) {
                $dates = [];
                $current = $r->start_date;
                while ($current->lte($r->end_date)) {
                    if ($current->month === now()->month && $current->year === now()->year) {
                        $dates[] = $current->format('Y-m-d');
                    }
                    $current = $current->addDay();
                }
                return $dates;
            })
            ->unique()
            ->count();

        $occupancyRate = $daysInMonth > 0
            ? round(($occupiedDates / $daysInMonth) * 100)
            : 0;

        return [
            Stat::make('Messages ce mois', ContactMessage::whereMonth('created_at', now()->month)->count())
                ->description('Demandes de contact reçues')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('info'),

            Stat::make('Messages non lus', ContactMessage::where('is_read', false)->count())
                ->description('En attente de réponse')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('danger'),

            Stat::make('Réservations à venir', Reservation::upcoming()->count())
                ->description('Séjours planifiés')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success'),

            Stat::make("Taux d'occupation", $occupancyRate . '%')
                ->description('Ce mois-ci (' . now()->translatedFormat('F Y') . ')')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($occupancyRate >= 70 ? 'success' : ($occupancyRate >= 40 ? 'warning' : 'gray')),
        ];
    }
}
