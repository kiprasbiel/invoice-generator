<x-jet-form-section submit="parse">
    <x-slot name="title">
        {{ __('Sąskaitų importas') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Importuokite sąskaitas') }}
    </x-slot>

    <x-slot name="form">
        <input type="file" wire:model.defer="file">
        <x-jet-input-error for="file" class="mt-2"/>

        <div class="flex items-start mt-4">
            <div class="flex items-center h-5">
                <input name="hasHeader" id="hasHeader" type="checkbox"
                       class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                       wire:model.defer="hasHeader">
            </div>
            <div class="ml-3 text-sm">
                <label for="hasHeader"
                       class="font-medium text-gray-700">{{ __('Failas turi antraštę su stulpelių pavadinimais') }}</label>
            </div>
            <x-jet-input-error for="hasHeader" class="mt-2"/>
        </div>

        <div class="w-full md:w-1/4 px-3 pt-5">
            <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="type">
                Pasirinkite ką importuojate
            </label>
            <select wire:model.defer="type" name="type"
                    class="mt-1 block w-full py-2 px-3 border border-gr`ay-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="Invoice">Sąskaitos</option>
                <option value="Client" selected>Klientai</option>
            </select>
            <x-jet-input-error for="type" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-button wire:loading.attr="enabled">
            {{ __('Išsaugoti') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
