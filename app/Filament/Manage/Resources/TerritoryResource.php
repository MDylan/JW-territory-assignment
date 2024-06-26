<?php

namespace App\Filament\Manage\Resources;

use App\Filament\Manage\Resources\TerritoryResource\Pages;
use App\Models\City;
use App\Models\Territory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TerritoryResource extends Resource
{
    protected static ?string $model = Territory::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('custom.model.territory.menu');
    }

    public static function getModelLabel(): string
    {
        return __('custom.model.territory.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('custom.model.territory.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('custom.menu.group.database');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('city_id')->translateLabel()
                    ->relationship('city', 'name')
                    ->required()
                    ->native(false)
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                        ->translateLabel()
                        ->required(),
                    ])
                    ->createOptionUsing(function (array $data): int {
                        $city = new City();
                        $city->name = $data['name'];
                        $city->save();
                        return $city->getKey();
                    }),
                Forms\Components\TextInput::make('number')->translateLabel()
                    ->required()
                    ->numeric(),
                Forms\Components\FileUpload::make('image_1')->translateLabel()
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '146:75',
                        '146:95',
                    ])
                    ->imageEditorMode(2)
                    ->downloadable()
                    ->panelAspectRatio('146:95'),
                Forms\Components\FileUpload::make('image_2')->translateLabel()
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '146:75',
                        '146:95',
                    ])
                    ->imageEditorMode(2)
                    ->downloadable()
                    ->panelAspectRatio('146:95'),
                Forms\Components\TextInput::make('comment')->translateLabel()
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')->translateLabel()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image_1')->translateLabel()->height(75)->simpleLightbox(),
                Tables\Columns\ImageColumn::make('image_2')->translateLabel()->height(75)->simpleLightbox(),
                Tables\Columns\TextColumn::make('city.name')->translateLabel()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_assigned')->translateLabel(),
                Tables\Columns\TextColumn::make('last_completed')->translateLabel(),
                Tables\Columns\TextColumn::make('created_at')->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->requiresConfirmation()->iconButton(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTerritories::route('/'),
            'create' => Pages\CreateTerritory::route('/create'),
            'view' => Pages\ViewTerritory::route('/{record}'),
            'edit' => Pages\EditTerritory::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
