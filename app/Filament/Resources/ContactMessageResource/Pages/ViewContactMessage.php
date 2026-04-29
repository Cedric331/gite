<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Resources\Pages\ViewRecord;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    // Marque automatiquement le message comme lu lors de la consultation
    protected function beforeFill(): void
    {
        $this->record->update(['is_read' => true]);
    }
}
