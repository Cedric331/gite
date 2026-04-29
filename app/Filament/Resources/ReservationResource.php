<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Models\Reservation;
use Filament\Actions;
use Filament\Schemas;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Réservations';
    protected static ?string $modelLabel = 'Réservation';
    protected static ?string $pluralModelLabel = 'Réservations';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Schemas\Components\Section::make('Client')->schema([
                Forms\Components\TextInput::make('guest_name')
                    ->label('Nom du client')
                    ->required()
                    ->maxLength(150),

                Forms\Components\TextInput::make('guest_email')
                    ->label('Email')
                    ->email()
                    ->maxLength(150),

                Forms\Components\TextInput::make('guest_phone')
                    ->label('Téléphone')
                    ->tel()
                    ->maxLength(20),
            ])->columns(3),

            Schemas\Components\Section::make('Séjour')->schema([
                Forms\Components\DatePicker::make('start_date')
                    ->label("Date d'arrivée")
                    ->required(),

                Forms\Components\DatePicker::make('end_date')
                    ->label('Date de départ')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Statut')
                    ->options([
                        'confirmed' => 'Confirmée',
                        'pending' => 'En attente',
                        'cancelled' => 'Annulée',
                        'blocked' => 'Bloquée (indisponible)',
                    ])
                    ->default('confirmed')
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3)
                    ->columnSpanFull(),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('guest_name')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Arrivée')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('Départ')
                    ->date('d/m/Y')
                    ->sortable(),

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
                        'cancelled' => 'Annulée',
                        'blocked' => 'Bloquée',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('guest_email')
                    ->label('Email')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('start_date')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'confirmed' => 'Confirmée',
                        'pending' => 'En attente',
                        'cancelled' => 'Annulée',
                        'blocked' => 'Bloquée',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Supprimer la réservation')
                    ->modalDescription('Êtes-vous sûr de vouloir supprimer cette réservation ? Cette action est irréversible.'),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}
