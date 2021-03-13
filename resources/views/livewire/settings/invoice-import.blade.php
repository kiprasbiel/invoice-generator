<x-jet-form-section submit="submit">
    <x-slot name="title">
        {{ __('Sąskaitų importas') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Importuokite sąskaitas') }}
    </x-slot>

    <x-slot name="form">
        <input type="file" wire:model="file">
        <x-jet-input-error for="file" class="mt-2"/>
    </x-slot>

    <x-slot name="actions">
        <x-jet-button wire:loading.attr="enabled">
            {{ __('Išsaugoti') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
