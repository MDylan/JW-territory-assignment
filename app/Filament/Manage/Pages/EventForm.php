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
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

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
                            ->live()
                            ->required(),
                        Forms\Components\Placeholder::make('')
                            ->content(function (Get $get) {
                                return new HtmlString($this->getTerritoryImage($get('territory_id')));
                            }),
                        Forms\Components\Select::make('publisher_id')->label(__('Publisher'))
                            ->options(Publisher::all()->pluck('name', 'id'))
                            ->searchable()
                            ->hidden(
                                fn (Get $get): bool => $this->getTerritoryPublisher($get('territory_id')))
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
                            ->default(fn (Get $get): bool => $this->getDefaultStatus($get('territory_id')))
                            ->inline(),
                        Forms\Components\DatePicker::make('selected_date')->translateLabel()->required(),

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

    private function getTerritoryPublisher($territory_id)
    {

        if(!$territory_id) return true;

        $territory = Event::where('congregation_id', Filament::getTenant()->id)
            ->whereNull('completed')
            ->where('territory_id', $territory_id)
            ->first();
        if($territory === null) return false;
        return true;
    }

    private function getDefaultStatus($territory_id)
    {
        if (!$territory_id) return 'assigned';

        $territory = Event::where('congregation_id', Filament::getTenant()->id)
            ->whereNull('completed')
            ->where('territory_id', $territory_id)
            ->first();
        if ($territory === null) return 'completed';
        return 'assigned';
    }

    private function getTerritoryImage($territory_id) {

        if (!$territory_id) return '';

        $string = '<div class="flex flex-row gap-4 justify-center items-center">';

        $territory = Territory::find($territory_id);
        if($territory->image_1) {
            $url = $territory->image_1;
            $string .= '<div class="basis-1/2"><img src="/storage/'. $url. '" style="height:75px;cursor:pointer;" class="simple-light-box-img-indicator" x-on:click="SimpleLightBox.open(event, \'' . $url . '\')" /></div>';
        }
        if ($territory->image_2) {
            $url = $territory->image_2;
            $string .= '<div class="basis-1/2"><img src="/storage/' . $url . '" style="height:75px;cursor:pointer;" class="simple-light-box-img-indicator" x-on:click="SimpleLightBox.open(event, \'' . $url . '\')" /></div>';
        }
        $string .= '</div>';

        return $string;
        //max-w-none object-cover object-center ring-white dark:ring-gray-900  simple-light-box-img-indicator
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            $data['congregation_id'] = Filament::getTenant()->id;
            //dd($data['congregation_id']);

            if($data['status'] == 'assigned') {
                $data['assigned'] = $data['selected_date'];
                unset($data['status']);
                unset($data['selected_date']);
                Event::create($data);
            } else {
                $data['completed'] = $data['selected_date'];

                unset($data['status']);
                unset($data['selected_date']);

                // dd($data);

                Event::updateOrCreate([
                    'territory_id' => $data['territory_id'],
                    'congregation_id' => $data['congregation_id'],
                    'completed' => null
                ], $data);

                // Event::where('territory_id', $data['territory_id'])
                //     ->where('congregation_id', $data['congregation_id'])
                //     ->whereNull('completed')
                //     ->update($data);
            }


            
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }
}
