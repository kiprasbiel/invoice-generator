<x-jet-form-section submit="submit">
    <x-slot name="title">
        {{ __('Išlaidos') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Įveskite bendrą išlaidų sumą') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="expenses" value="{{ __('Bendra išlaidų suma') }}"/>
            <x-jet-input id="expenses" type="text" class="mt-1 block w-full" wire:model.defer="expenses"/>
            <x-jet-input-error for="expenses" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-button wire:loading.attr="enabled">
            {{ __('Išsaugoti') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
