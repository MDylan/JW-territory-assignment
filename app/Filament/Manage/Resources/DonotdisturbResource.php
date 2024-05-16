<?php

namespace App\Filament\Manage\Resources;

use App\Filament\Manage\Resources\DonotdisturbResource\Pages;
use App\Filament\Manage\Resources\DonotdisturbResource\RelationManagers;
use App\Models\Donotdisturb;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DonotdisturbResource extends Resource
{
    protected static ?string $model = Donotdisturb::class;

    protected static ?string $navigationIcon = 'heroicon-o-no-symbol';

    protected static ?string $slug = 'do-not-disturbs';

    protected static ?int $navigationSort = 4;

    public static function getNavigationLabel(): string
    {
        return __('custom.model.donotdisturb.menu');
    }

    public static function getModelLabel(): string
    {
        return __('custom.model.donotdisturb.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('custom.model.donotdisturb.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('custom.menu.group.database');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('congregation_id')->translateLabel()
                    ->relationship('congregation', 'name')
                    ->required(),
                Forms\Components\Select::make('territory_id')->translateLabel()
                    ->relationship('territory', 'id')
                    ->required(),
                Forms\Components\TextInput::make('name')->translateLabel()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DatePicker::make('last_visit')->translateLabel()
                    ->required(),
                Forms\Components\TextInput::make('comment')->translateLabel()
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('congregation.name')->translateLabel()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('territory.id')->translateLabel()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_visit')->translateLabel()
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('comment')->translateLabel()
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
            'index' => Pages\ListDonotdisturbs::route('/'),
            'create' => Pages\CreateDonotdisturb::route('/create'),
            'edit' => Pages\EditDonotdisturb::route('/{record}/edit'),
        ];
    }
}
