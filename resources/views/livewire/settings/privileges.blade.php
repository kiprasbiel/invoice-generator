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
                    <input name="isFreeMarketActivity" value="yes" id="FreeMarker" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" wire:model.defer="isFreeMarketActivity">
                </div>
                <div class="ml-3 text-sm" id="freeActivity">
                    <label for="FreeMarker" class="font-medium text-gray-700">{{ __('Jūsų profesija yra laikoma laisvąja profesija') }}
                        <svg fill="none" height="14" viewBox="0 0 14 14" width="14" class="inline text-blue-500">
                            <path
                                d="M0 7C0 3.16129 3.13306 0 7 0C10.8387 0 14 3.16129 14 7C14 10.8669 10.8387 14 7 14C3.13306 14 0 10.8669 0 7Z"
                                fill="currentColor"></path>
                            <path
                                d="M7 2C7.82143 2 8.5 2.64286 8.5 3.42105C8.5 4.23308 7.82143 4.84211 7 4.84211C6.14286 4.84211 5.5 4.23308 5.5 3.42105C5.5 2.64286 6.14286 2 7 2ZM9 10.594C9 10.8308 8.78571 11 8.57143 11H5.42857C5.17857 11 5 10.8308 5 10.594V9.78196C5 9.57895 5.17857 9.37594 5.42857 9.37594H5.85714V7.21053H5.42857C5.17857 7.21053 5 7.04135 5 6.80451V5.99248C5 5.78947 5.17857 5.58647 5.42857 5.58647H7.71429C7.92857 5.58647 8.14286 5.78947 8.14286 5.99248V9.37594H8.57143C8.78571 9.37594 9 9.57895 9 9.78196V10.594Z"
                                fill="white"></path>
                        </svg>
                    </label>
                </div>
            </div>

            <div class="flex items-start mt-4">
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
                <div class="ml-3 text-sm" id="firstTimer_label">
                    <label for="firstTimer" class="font-medium text-gray-700">{{ __('Individualią veiklą vykdote pirmą kartą') }}
                        <svg fill="none" height="14" viewBox="0 0 14 14" width="14" class="inline text-blue-500">
                            <path
                                d="M0 7C0 3.16129 3.13306 0 7 0C10.8387 0 14 3.16129 14 7C14 10.8669 10.8387 14 7 14C3.13306 14 0 10.8669 0 7Z"
                                fill="currentColor"></path>
                            <path
                                d="M7 2C7.82143 2 8.5 2.64286 8.5 3.42105C8.5 4.23308 7.82143 4.84211 7 4.84211C6.14286 4.84211 5.5 4.23308 5.5 3.42105C5.5 2.64286 6.14286 2 7 2ZM9 10.594C9 10.8308 8.78571 11 8.57143 11H5.42857C5.17857 11 5 10.8308 5 10.594V9.78196C5 9.57895 5.17857 9.37594 5.42857 9.37594H5.85714V7.21053H5.42857C5.17857 7.21053 5 7.04135 5 6.80451V5.99248C5 5.78947 5.17857 5.58647 5.42857 5.58647H7.71429C7.92857 5.58647 8.14286 5.78947 8.14286 5.99248V9.37594H8.57143C8.78571 9.37594 9 9.57895 9 9.78196V10.594Z"
                                fill="white"></path>
                        </svg>
                    </label>
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
        <x-jet-button wire:loading.attr="disabled">
            {{ __('Išsaugoti') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
