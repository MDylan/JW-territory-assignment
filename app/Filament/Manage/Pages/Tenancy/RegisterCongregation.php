<?php

namespace App\Filament\Manage\Pages\Tenancy;

use App\Models\Congregation;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterCongregation extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Create a congregation';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
            ]);
    }

    protected function handleRegistration(array $data): Congregation
    {
        $team = Congregation::create($data);

        $team->members()->attach(auth()->user());

        return $team;
    }
}