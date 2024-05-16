<?php

namespace App\Filament\Manage\Resources;

use App\Filament\Manage\Resources\EventResource\Pages;
use App\Filament\Manage\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    public static function getNavigationLabel(): string
    {
        return __('custom.model.event.menu');
    }

    public static function getModelLabel(): string
    {
        return __('custom.model.event.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('custom.model.event.plural_label');
    } 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('congregation_id')
                    ->relationship('congregation', 'name')
                    ->required(),
                Forms\Components\Select::make('territory_id')
                    ->relationship('territory', 'id')
                    ->required(),
                Forms\Components\Select::make('publisher_id')
                    ->relationship('publisher', 'name')
                    ->default(null),
                Forms\Components\DatePicker::make('assigned'),
                Forms\Components\DatePicker::make('completed'),
                Forms\Components\TextInput::make('comment')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('congregation.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('territory.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('publisher.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assigned')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('completed')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('comment')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'view' => Pages\ViewEvent::route('/{record}'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
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