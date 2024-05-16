<?php

namespace App\Filament\Manage\Pages;

use App\Models\Event;
use App\Models\Publisher;
use App\Models\Territory;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;

class EventForm extends Page implements HasForms
{

    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';

    protected static string $view = 'filament.manage.pages.event-form';

    public ?array $data = [];

    public function getHeading(): string
    {
        return false; //__('Handling a territory');
    }

    public static function getNavigationLabel(): string
    {
        return __('Handling a territory');
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->heading(__('Handling a territory'))
                    ->icon($this->getNavigationIcon())
                    ->schema([
                        Forms\Components\Select::make('territory_id')->label(__('Territory'))
                            ->options(Territory::all()->pluck('full_name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('publisher_id')->label(__('Publisher'))
                            ->options(Publisher::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\ToggleButtons::make('status')->translateLabel()
                            ->options([
                                'assigned' => __('Assigned'),
                                'completed' => __('Completed')
                            ])
                            ->icons([
                                'assigned' => 'heroicon-o-arrow-up-on-square',
                                'completed' => 'heroicon-o-arrow-down-on-square',
                            ])
                            ->colors([
                                'assigned' => 'info',
                                'completed' => 'success',
                            ])
                            ->inline(),
                        Forms\Components\DatePicker::make('selected_date')->translateLabel()->required()
                    ])

            ])
            ->statePath('data')
            ->columns(1);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
            ->icon('heroicon-o-document-check')
            ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
            ->submit('save'),
        ];
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            $data['congregation_id'] = Filament::getTenant()->id;
            //dd($data['congregation_id']);

            if($data['status'] == 'assigned') {
                $data['assigned'] = $data['selected_date'];
            } else {
                $data['completed'] = $data['selected_date'];
            }            

            Event::create($data);
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }
}
