<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CongregationResource\Pages;
use App\Filament\Resources\CongregationResource\RelationManagers;
use App\Models\Congregation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CongregationResource extends Resource
{
    protected static ?string $model = Congregation::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getNavigationLabel(): string
    {
        return __('custom.model.congregation.menu');
    }

    public static function getModelLabel(): string
    {
        return __('custom.model.congregation.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('custom.model.congregation.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->translateLabel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')->translateLabel()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListCongregations::route('/'),
            'create' => Pages\CreateCongregation::route('/create'),
            'view' => Pages\ViewCongregation::route('/{record}'),
            'edit' => Pages\EditCongregation::route('/{record}/edit'),
        ];
    }
}
