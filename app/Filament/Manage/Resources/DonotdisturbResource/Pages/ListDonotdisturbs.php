<?php

namespace App\Filament\Manage\Resources\DonotdisturbResource\Pages;

use App\Filament\Manage\Resources\DonotdisturbResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDonotdisturbs extends ListRecords
{
    protected static string $resource = DonotdisturbResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
