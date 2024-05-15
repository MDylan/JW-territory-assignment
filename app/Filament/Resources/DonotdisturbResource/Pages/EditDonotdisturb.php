<?php

namespace App\Filament\Resources\DonotdisturbResource\Pages;

use App\Filament\Resources\DonotdisturbResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDonotdisturb extends EditRecord
{
    protected static string $resource = DonotdisturbResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
