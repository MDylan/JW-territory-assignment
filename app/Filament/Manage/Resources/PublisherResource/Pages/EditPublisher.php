<?php

namespace App\Filament\Manage\Resources\PublisherResource\Pages;

use App\Filament\Manage\Resources\PublisherResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPublisher extends EditRecord
{
    protected static string $resource = PublisherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
