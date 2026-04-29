<?php

namespace App\Filament\Resources\PhotoResource\Pages;

use App\Filament\Resources\PhotoResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePhoto extends CreateRecord
{
    protected static string $resource = PhotoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Si la photo est marquée comme principale, désactiver les autres
        if ($data['is_main'] ?? false) {
            \App\Models\Photo::where('is_main', true)->update(['is_main' => false]);
        }
        return $data;
    }
}
