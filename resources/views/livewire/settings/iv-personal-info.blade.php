<x-jet-form-section submit="submit">
    <x-slot name="title">
        {{ __('Veiklos informacija') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ši informacija bus matoma išrašant sąskaita-faktūrą.') }}
    </x-slot>

    <x-slot name="form">
        <!-- TODO: Invoice LOGO -->

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="full_name" value="{{ __('Vardas ir pavardė') }}"/>
            <x-jet-input id="full_name" type="text" class="mt-1 block w-full" wire:model.defer="full_name"
                         autocomplete="name"/>
            <x-jet-input-error for="full_name" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="iv_code" value="{{ __('IV numeris') }}"/>
            <x-jet-input id="iv_code" type="text" class="mt-1 block w-full" wire:model.defer="iv_code"/>
            <x-jet-input-error for="iv_code" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="vat" value="{{ __('PVM') }}"/>
            <x-jet-input id="vat" type="text" class="mt-1 block w-full" wire:model.defer="vat"/>
            <x-jet-input-error for="vat" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="personal_code" value="{{ __('Asmens kodas') }}"/>
            <x-jet-input id="personal_code" type="text" class="mt-1 block w-full" wire:model.defer="personal_code"/>
            <x-jet-input-error for="personal_code" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="address" value="{{ __('Adresas') }}"/>
            <x-jet-input id="address" type="text" class="mt-1 block w-full" wire:model.defer="address"/>
            <x-jet-input-error for="address" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="phone" value="{{ __('Telefono numeris') }}"/>
            <x-jet-input id="phone" type="text" class="mt-1 block w-full" wire:model.defer="phone"/>
            <x-jet-input-error for="phone" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('El. paštas') }}"/>
            <x-jet-input id="email" type="text" class="mt-1 block w-full" wire:model.defer="email"/>
            <x-jet-input-error for="email" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="additional_info" value="{{ __('Papildoma informacija') }}"/>
            <x-jet-input id="additional_info" type="text" class="mt-1 block w-full" wire:model.defer="additional_info"/>
            <x-jet-input-error for="additional_info" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="bank_name" value="{{ __('Banko pavadinimas') }}"/>
            <x-jet-input id="bank_name" type="text" class="mt-1 block w-full" wire:model.defer="bank_name"/>
            <x-jet-input-error for="bank_name" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="bank_account_num" value="{{ __('Banko sąskaitos numeris') }}"/>
            <x-jet-input id="bank_account_num" type="text" class="mt-1 block w-full" wire:model.defer="bank_account_num"/>
            <x-jet-input-error for="bank_account_num" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-button wire:loading.attr="enabled">
            {{ __('Išsaugoti') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
