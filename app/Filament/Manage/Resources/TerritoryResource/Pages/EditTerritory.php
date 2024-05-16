<?php

namespace App\Filament\Manage\Resources\TerritoryResource\Pages;

use App\Filament\Manage\Resources\TerritoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTerritory extends EditRecord
{
    protected static string $resource = TerritoryResource::class;

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
