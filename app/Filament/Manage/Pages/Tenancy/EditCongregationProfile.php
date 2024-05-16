<?php

namespace App\Filament\Manage\Pages\Tenancy;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;

class EditCongregationProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Congregation profile';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([TextInput::make('name')
                ->required(),
            TextInput::make('slug')
                ->readOnly(),
            ])->columns(2);
    }
}