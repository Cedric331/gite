<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Contenu du site';
    protected static ?string $modelLabel = 'Paramètre';
    protected static ?string $pluralModelLabel = 'Contenu & Paramètres';
    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('key')
                ->label('Clé')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(100),

            Forms\Components\Select::make('group')
                ->label('Groupe')
                ->options([
                    'general' => 'Général',
                    'hero' => "Page d'accueil (Hero)",
                    'gite' => 'Le Gîte',
                    'contact' => 'Contact',
                    'seo' => 'SEO',
                ])
                ->required(),

            Forms\Components\Textarea::make('value')
                ->label('Valeur')
                ->rows(3)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Clé')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('group')
                    ->label('Groupe'),

                Tables\Columns\TextColumn::make('value')
                    ->label('Valeur')
                    ->limit(60),
            ])
            ->defaultSort('group')
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->label('Groupe')
                    ->options([
                        'general' => 'Général',
                        'hero' => "Page d'accueil",
                        'gite' => 'Le Gîte',
                        'contact' => 'Contact',
                        'seo' => 'SEO',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
