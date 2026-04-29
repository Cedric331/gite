<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Actions;
use Filament\Schemas;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Messages de contact';
    protected static ?string $modelLabel = 'Message';
    protected static ?string $pluralModelLabel = 'Messages de contact';
    protected static ?int $navigationSort = 5;

    // Badge de notification pour les messages non lus
    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('is_read', false)->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Schemas\Components\Section::make('Coordonnées')->schema([
                Forms\Components\TextInput::make('name')->label('Nom')->disabled(),
                Forms\Components\TextInput::make('email')->label('Email')->disabled(),
                Forms\Components\TextInput::make('phone')->label('Téléphone')->disabled(),
            ])->columns(3),

            Schemas\Components\Section::make('Demande de séjour')->schema([
                Forms\Components\DatePicker::make('start_date')->label("Arrivée souhaitée")->disabled(),
                Forms\Components\DatePicker::make('end_date')->label("Départ souhaité")->disabled(),
                Forms\Components\TextInput::make('guests')->label('Nb personnes')->disabled(),
            ])->columns(3),

            Schemas\Components\Section::make('Message')->schema([
                Forms\Components\Textarea::make('message')->label('')->rows(6)->disabled(),
                Forms\Components\Toggle::make('is_read')->label('Marqué comme lu'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_read')
                    ->label('')
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('gray')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->weight(fn ($record) => $record->is_read ? null : 'bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Arrivée')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('guests')
                    ->label('Pers.'),

                Tables\Columns\TextColumn::make('message')
                    ->label('Message')
                    ->limit(60)
                    ->tooltip(fn ($record) => $record->message),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Reçu le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('Statut lecture')
                    ->trueLabel('Lus')
                    ->falseLabel('Non lus')
                    ->native(false),
            ])
            ->recordAction('view')
            ->actions([
                Actions\Action::make('toggle_read')
                    ->label(fn ($record) => $record->is_read ? 'Marquer non lu' : 'Marquer lu')
                    ->icon(fn ($record) => $record->is_read ? 'heroicon-o-envelope' : 'heroicon-o-envelope-open')
                    ->action(fn ($record) => $record->update(['is_read' => !$record->is_read])),

                Actions\ViewAction::make(),
                Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Supprimer le message')
                    ->modalDescription('Êtes-vous sûr de vouloir supprimer ce message ?'),
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
            'index' => Pages\ListContactMessages::route('/'),
            'view' => Pages\ViewContactMessage::route('/{record}'),
        ];
    }
}
