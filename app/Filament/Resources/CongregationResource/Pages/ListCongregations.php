<?php

namespace App\Filament\Resources\CongregationResource\Pages;

use App\Filament\Resources\CongregationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCongregations extends ListRecords
{
    protected static string $resource = CongregationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
