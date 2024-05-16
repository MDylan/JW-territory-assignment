<?php

namespace App\Filament\Resources\CongregationResource\Pages;

use App\Filament\Resources\CongregationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCongregation extends ViewRecord
{
    protected static string $resource = CongregationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
