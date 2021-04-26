<x-jet-form-section submit="submit">
    <x-slot name="title">
        {{ __('Automatiniai el. laiškai') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Įveskite automatinių el. laiškų turinį. Šie laiškai automatiškai primins jūsų klientams apie dar neapmokėtas sąskaitas.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-6">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input name="autoSend" id="autoSend" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" wire:model.defer="autoSend">
                </div>
                <div class="ml-3 text-sm">
                    <label for="autoSend" class="font-medium text-gray-700">{{ __('Siųsti el. paštu automatinius sąskaitų apmokėjimo priminimus') }}</label>
                </div>
            </div>

            <x-jet-input-error for="autoSend" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-6">
            <x-jet-label for="sender" value="{{ __('El. paštas kurį matys laiško gavėjas') }}"/>
            <x-jet-input id="sender" type="text" class="mt-1 block w-full" wire:model.defer="sender"/>
            <x-jet-input-error for="sender" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-6">
            <x-jet-label for="headline" value="{{ __('Antraštė') }}"/>
            <x-jet-input id="headline" type="text" class="mt-1 block w-full" wire:model.defer="headline"/>
            <x-jet-input-error for="headline" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-6">
            <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="messageBody">
                Turinys
            </label>
            <textarea wire:model.defer="messageBody"
                      class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                      id="messageBody" rows="5"></textarea>
            @error('messageBody') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-jet-button wire:loading.attr="enabled">
            {{ __('Išsaugoti') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
