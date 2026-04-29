<?php

namespace App\Filament\Widgets;

use App\Models\Reservation;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UpcomingReservationsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Prochaines réservations';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Reservation::upcoming()->orderBy('start_date')->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('guest_name')
                    ->label('Client'),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Arrivée')
                    ->date('d/m/Y'),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('Départ')
                    ->date('d/m/Y'),

                Tables\Columns\TextColumn::make('nights')
                    ->label('Nuits')
                    ->getStateUsing(fn ($record) => $record->start_date->diffInDays($record->end_date)),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Statut')
                    ->colors([
                        'success' => 'confirmed',
                        'warning' => 'pending',
                        'danger' => 'cancelled',
                        'gray' => 'blocked',
                    ])
                    ->formatStateUsing(fn ($state) => match($state) {
                        'confirmed' => 'Confirmée',
                        'pending' => 'En attente',
                        default => $state,
                    }),
            ]);
    }
}
