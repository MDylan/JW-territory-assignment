<?php

namespace App\Filament\Manage\Resources\EventResource\Pages;

use App\Filament\Manage\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;
}
