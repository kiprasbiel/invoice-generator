<x-jet-form-section submit="submit">
    <x-slot name="title">
        {{ __('Sąskaita-faktūra') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Nurodykite sąskaitos-faktūros numerį') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="sf_code" value="{{ __('Sąskaitos-faktūros priešdėlis') }}"/>
            <x-jet-input id="sf_code" type="text" class="mt-1 block w-full" wire:model.defer="sf_code"/>
            <x-jet-input-error for="sf_code" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Išsaugota.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Išsaugoti') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>