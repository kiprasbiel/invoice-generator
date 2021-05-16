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

            <livewire:settings.mail />

            <x-jet-section-border/>

            @livewire('settings.privileges')

            <x-jet-section-border/>

            <livewire:settings.invoice-import/>
            <livewire:parse-import/>

        </div>
    </div>

    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script>
        tippy('#firstTimer_label', {
            content: 'Pirmus metus vykdydami individualią veiklą, galite pasirinkti nemokėti metinės VSD įmokos. Daugiau informacijos rasite <a style="color: #3f83f8" href="https://www.sodra.lt/lt/situacijos/vykdau-individualia-veikla?el_id=2045">čia.</a>',
            placement: 'right',
            allowHTML: true,
            interactive: true,
        });
        tippy('#freeActivity', {
            allowHTML: true,
            content: 'Asmenys užsiimantys laisvąją profesija moka 15% GPM. Daugiau informacijos rasite <a style="color: #3f83f8" href="https://www.vmi.lt/cms/gyventoju-pajamu-mokestis9">čia.</a>',
            placement: 'right',
            interactive: true,
        });
    </script>

</x-app-layout>
