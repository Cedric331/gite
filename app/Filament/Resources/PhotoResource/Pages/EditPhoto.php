<?php

namespace App\Filament\Resources\PhotoResource\Pages;

use App\Filament\Resources\PhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPhoto extends EditRecord
{
    protected static string $resource = PhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['is_main'] ?? false) {
            \App\Models\Photo::where('id', '!=', $this->record->id)
                ->where('is_main', true)
                ->update(['is_main' => false]);
        }
        return $data;
    }
}
