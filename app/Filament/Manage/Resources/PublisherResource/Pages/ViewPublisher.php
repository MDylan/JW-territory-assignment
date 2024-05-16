<?php

namespace App\Filament\Manage\Resources\PublisherResource\Pages;

use App\Filament\Manage\Resources\PublisherResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPublisher extends ViewRecord
{
    protected static string $resource = PublisherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
