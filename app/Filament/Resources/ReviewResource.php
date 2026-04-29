<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Actions;
use Filament\Schemas;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationLabel = 'Avis clients';
    protected static ?string $modelLabel = 'Avis';
    protected static ?string $pluralModelLabel = 'Avis clients';
    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Schemas\Components\Section::make("Avis client")->schema([
                Forms\Components\TextInput::make('author')
                    ->label('Auteur')
                    ->required()
                    ->maxLength(100),

                Forms\Components\Select::make('rating')
                    ->label('Note')
                    ->options([1 => '★ 1/5', 2 => '★★ 2/5', 3 => '★★★ 3/5', 4 => '★★★★ 4/5', 5 => '★★★★★ 5/5'])
                    ->required(),

                Forms\Components\DatePicker::make('date')
                    ->label('Date du séjour')
                    ->required()
                    ->default(now()),

                Forms\Components\Toggle::make('is_active')
                    ->label('Visible sur le site')
                    ->default(true),

                Forms\Components\Textarea::make('comment')
                    ->label('Commentaire')
                    ->required()
                    ->rows(4)
                    ->maxLength(1000)
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author')
                    ->label('Auteur')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Note')
                    ->formatStateUsing(fn ($state) => str_repeat('★', $state) . str_repeat('☆', 5 - $state)),

                Tables\Columns\TextColumn::make('comment')
                    ->label('Commentaire')
                    ->limit(80),

                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Visible'),
            ])
            ->defaultSort('date', 'desc')
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make()->requiresConfirmation(),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
