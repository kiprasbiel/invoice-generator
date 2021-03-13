<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Veiklos nustatymai') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('settings.iv-personal-info')

            <x-jet-section-border/>

            @livewire('settings.sf-number-settings')

            <x-jet-section-border/>

            @livewire('settings.privileges')

            <x-jet-section-border/>

            <livewire:settings.invoice-import/>

        </div>
    </div>
</x-app-layout>
