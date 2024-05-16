<x-filament-panels::page>
    <div class="flex justify-center items-center w-full">
        <div class="w-full sm:px-12 sm:max-w-lg">
            <x-filament-panels::form  wire:submit="save">
                {{ $this->form }}
                <x-filament-panels::form.actions 
                    :actions="$this->getFormActions()"
                /> 
            </x-filament-panels::form>
        </div>
    </div>
</x-filament-panels::page>
