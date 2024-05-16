<?php

namespace App\Filament\Manage\Resources\PublisherResource\Pages;

use App\Filament\Manage\Resources\PublisherResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPublishers extends ListRecords
{
    protected static string $resource = PublisherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
