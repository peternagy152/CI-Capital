<x-filament-panels::page>

    <h1> Import Your Macro Sheet </h1>
    <form wire:submit.prevent="submit">
        {{$this->form}}

        <!-- Add the submit button manually -->
        <div class="mt-4">
            <x-filament::button type="submit">
                {{ __('Submit') }}
            </x-filament::button>
        </div>
    </form>

</x-filament-panels::page>
