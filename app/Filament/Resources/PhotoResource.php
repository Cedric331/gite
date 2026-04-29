<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhotoResource\Pages;
use App\Models\Photo;
use Filament\Actions;
use Filament\Schemas;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PhotoResource extends Resource
{
    protected static ?string $model = Photo::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Galerie photos';
    protected static ?string $modelLabel = 'Photo';
    protected static ?string $pluralModelLabel = 'Photos';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Schemas\Components\Section::make('Photo')->schema([
                Forms\Components\FileUpload::make('filename')
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('photos')
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('1200')
                    ->imageResizeTargetHeight('675')
                    ->required(),

                Forms\Components\TextInput::make('alt')
                    ->label('Texte alternatif (accessibilité)')
                    ->placeholder('Description de la photo pour les personnes malvoyantes')
                    ->maxLength(200),

                Forms\Components\Select::make('category')
                    ->label('Catégorie')
                    ->options([
                        'general' => 'Général',
                        'chambre' => 'Chambre',
                        'salon' => 'Salon',
                        'cuisine' => 'Cuisine',
                        'exterieur' => 'Extérieur',
                    ])
                    ->default('general')
                    ->required(),

                Forms\Components\TextInput::make('order')
                    ->label("Ordre d'affichage")
                    ->numeric()
                    ->default(0),

                Forms\Components\Toggle::make('is_main')
                    ->label('Photo principale (hero)')
                    ->helperText('Une seule photo peut être principale'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('filename')
                    ->label('Aperçu')
                    ->disk('public')
                    ->square(),

                Tables\Columns\TextColumn::make('alt')
                    ->label('Description')
                    ->limit(40)
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('category')
                    ->label('Catégorie')
                    ->colors([
                        'primary' => 'general',
                        'success' => 'exterieur',
                        'warning' => 'salon',
                        'danger' => 'chambre',
                        'gray' => 'cuisine',
                    ]),

                Tables\Columns\TextColumn::make('order')
                    ->label('Ordre')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_main')
                    ->label('Principale')
                    ->boolean(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Catégorie')
                    ->options([
                        'general' => 'Général',
                        'chambre' => 'Chambre',
                        'salon' => 'Salon',
                        'cuisine' => 'Cuisine',
                        'exterieur' => 'Extérieur',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
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
            'index' => Pages\ListPhotos::route('/'),
            'create' => Pages\CreatePhoto::route('/create'),
            'edit' => Pages\EditPhoto::route('/{record}/edit'),
        ];
    }
}
