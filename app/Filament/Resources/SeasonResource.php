<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeasonResource\Pages;
use App\Models\Season;
use Filament\Actions;
use Filament\Schemas;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SeasonResource extends Resource
{
    protected static ?string $model = Season::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-currency-euro';
    protected static ?string $navigationLabel = 'Tarifs & Saisons';
    protected static ?string $modelLabel = 'Saison';
    protected static ?string $pluralModelLabel = 'Saisons';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Schemas\Components\Section::make('Informations de la saison')->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nom de la saison')
                    ->placeholder('Ex: Haute saison')
                    ->required()
                    ->maxLength(100),

                Forms\Components\TextInput::make('slug')
                    ->label('Identifiant')
                    ->placeholder('Ex: high')
                    ->required()
                    ->maxLength(50),

                Forms\Components\DatePicker::make('start_date')
                    ->label('Début')
                    ->required(),

                Forms\Components\DatePicker::make('end_date')
                    ->label('Fin')
                    ->required(),
            ])->columns(2),

            Schemas\Components\Section::make('Tarifs')->schema([
                Forms\Components\TextInput::make('price_per_night')
                    ->label('Prix par nuit (€)')
                    ->numeric()
                    ->prefix('€')
                    ->required(),

                Forms\Components\TextInput::make('price_per_week')
                    ->label('Prix à la semaine (€)')
                    ->numeric()
                    ->prefix('€')
                    ->required(),

                Forms\Components\ColorPicker::make('color')
                    ->label("Couleur d'affichage")
                    ->default('#6366f1'),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColorColumn::make('color')->label(''),
                Tables\Columns\TextColumn::make('name')->label('Saison')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('start_date')->label('Début')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('end_date')->label('Fin')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('price_per_night')->label('Prix/nuit')->money('EUR')->sortable(),
                Tables\Columns\TextColumn::make('price_per_week')->label('Prix/semaine')->money('EUR')->sortable(),
            ])
            ->defaultSort('start_date')
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeasons::route('/'),
            'create' => Pages\CreateSeason::route('/create'),
            'edit' => Pages\EditSeason::route('/{record}/edit'),
        ];
    }
}
