<?php

namespace App\Filament\Manage\Pages;

use App\Models\Event;
use App\Models\Publisher;
use App\Models\Territory;
use Closure;
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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rule;

class EventForm extends Page implements HasForms
{

    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';

    protected static string $view = 'filament.manage.pages.event-form';

    public ?array $data = [];

    public ?array $last_assignment = [];

    public function getHeading(): string
    {
        return false; //__('Handling a territory');
    }

    public function getTitle(): string
    {
        return __('Handling a territory');
    }

    public static function getNavigationLabel(): string
    {
        return __('Handling a territory');
    }

    public function mount(): void
    {
        $this->form->fill([]);
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

                Forms\Components\Placeholder::make('')
                    ->content(function (Get $get) {
                        if(!$get('territory_id')) return '';
                        return  new HtmlString($this->getLastPublisher($get('territory_id')));
                    }),
                        Forms\Components\Select::make('publisher_id')->label(__('Publisher'))
                            ->options(Publisher::where('congregation_id', Filament::getTenant()->id)->pluck('name', 'id'))
                            ->searchable()
                            ->hidden(
                                fn (Get $get): bool => $this->getTerritoryPublisher($get('territory_id')))
                            ->required(),
                        Forms\Components\DatePicker::make('assigned')
                            ->translateLabel()
                            ->required()
                            ->beforeOrEqual('today')
                            ->validationMessages([
                                'before_or_equal' => __('custom.validation.assigned_before_or_equal'),
                            ])
                            ->hidden(function (Get $get): bool {
                                return !$this->getCompleted($get('territory_id'));
                            }),
                        Forms\Components\DatePicker::make('completed')
                            ->translateLabel()
                            ->required()
                            ->beforeOrEqual('today')
                            ->rules([
                                fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                    if(count($this->last_assignment) > 0) {
                                        if ($value < $this->last_assignment['assigned']) {
                                            $fail(__('custom.validation.completed_before_assigned', ['date' => $this->last_assignment['assigned']]));
                                        }
                                    }
                                },
                            ])
                            ->validationMessages([
                                'before_or_equal' => __('custom.validation.completed_before_or_equal'),
                            ])
                            ->hidden(function (Get $get): bool {
                                if(!$get('territory_id')) return true;
                                return $this->getCompleted($get('territory_id'));
                            }),


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

    /**
     * @return true if territory is assigned currently
     */
    private function getCompleted($territory_id) : bool
    {
        if (!$territory_id) return false;

        $territory = Event::where('congregation_id', Filament::getTenant()->id)
            ->whereNull('completed')
            ->where('territory_id', $territory_id)
            ->first();
        // dd($territory);
        if ($territory === null) return true;
        else {
            $this->last_assignment = $territory->toArray();
        }
        return false;
    }

    private function getLastPublisher($territory_id) : string
    {
        if (!$territory_id) return '';

        $string = '';
        $string .= '<div class="flex justify-center items-center">';
        $territory = Event::with('publisher')->where('congregation_id', Filament::getTenant()->id)
            ->where('territory_id', $territory_id)
            ->latest()
            ->first();
        //  dd($territory);
        if($territory === null) $string .= __('custom.not_assigned');
        else {
            if($territory->completed) {
                $string .= __('custom.last_completed', ['name' => $territory->publisher->name ?? __('custom.not_defined'), 'date' => $territory->completed]);
                
            } elseif($territory->assigned) {
                $string .= __('custom.assigned_to', ['name' => $territory->publisher->name ?? __('custom.not_defined'), 'date' => $territory->assigned]);            
            }
        }
        $string .= '</div>';
        return $string;
    }

    private function getTerritoryImage($territory_id) {

        if (!$territory_id) return '';

        $string = '';
        $territory = Territory::find($territory_id);

        if ($territory->image_1 || $territory->image_2) {

            $string .= '<div class="flex flex-row gap-4 justify-center items-center">';
            if($territory->image_1) {
                $url = $territory->image_1;
                $string .= '<div class="basis-1/2"><img src="/storage/'. $url. '" style="height:75px;cursor:pointer;" class="simple-light-box-img-indicator" x-on:click="SimpleLightBox.open(event, \'' . $url . '\')" /></div>';
            }
            if ($territory->image_2) {
                $url = $territory->image_2;
                $string .= '<div class="basis-1/2"><img src="/storage/' . $url . '" style="height:75px;cursor:pointer;" class="simple-light-box-img-indicator" x-on:click="SimpleLightBox.open(event, \'' . $url . '\')" /></div>';
            }
            $string .= '</div>';
        }
        

        return $string;
    }

    public function save(): void
    {

        $congregation_id = Filament::getTenant()->id;

        if(!$congregation_id) return;

        try {
            $data = $this->form->getState();
            $data['congregation_id'] = $congregation_id;

            //dd($data);
            //Data validated by filament

            Event::updateOrCreate([
                'territory_id' => $data['territory_id'],
                'congregation_id' => $data['congregation_id'],
                'completed' => null
            ], $data);
            
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
        $this->reset();
    }
}
