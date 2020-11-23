<x-jet-form-section submit="submit">
    <x-slot name="title">
        {{ __('Lengvatos ir kiti mokesčių nustatymai') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Nurodykite jums taikomas mokesčių lengvatas') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input name="isStudent" value="yes" id="student" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" wire:model.defer="isStudent">
                </div>
                <div class="ml-3 text-sm">
                    <label for="student" class="font-medium text-gray-700">{{ __('Esate draustas privalomu sveikatos draudimu') }}</label>
                </div>
            </div>

            <div class="flex items-start mt-4">
                <div class="flex items-center h-5">
                    <input name="isFirstTimer" value="yes" id="firstTimer" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" wire:model.defer="isFirstTimer">
                </div>
                <div class="ml-3 text-sm">
                    <label for="firstTimer" class="font-medium text-gray-700">{{ __('Individualią veiklą vykdote pirmą kartą') }}</label>
                </div>
            </div>

            <div class="flex items-start mt-4">
                <div class="flex items-center h-5">
                    <input name="isPensioner" value="yes" id="pensioner" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" wire:model.defer="isPensioner">
                </div>
                <div class="ml-3 text-sm">
                    <label for="pensioner" class="font-medium text-gray-700">{{ __('Gaunate pensiją') }}</label>
                </div>
            </div>

            <fieldset>
                <div>
                    <p class="mt-4 text-sm text-gray-700">Kaupiate papildomai pensijai</p>
                </div>

                <div class="mt-2 space-y-4">
                    @foreach($pensionsTypes as $type => $text)
                        <div class="flex items-center">
                            <input id="{{ $type }}" name="pens" value="{{ $type }}" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" wire:model.defer="additionalPension">
                            <label for="{{ $type }}" class="ml-3 block text-sm font-medium text-gray-700">
                                {{ $text }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </fieldset>

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
