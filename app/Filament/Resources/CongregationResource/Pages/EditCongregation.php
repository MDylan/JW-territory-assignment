<?php

namespace App\Filament\Resources\CongregationResource\Pages;

use App\Filament\Resources\CongregationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCongregation extends EditRecord
{
    protected static string $resource = CongregationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
