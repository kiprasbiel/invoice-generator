<div class="flex flex-wrap overflow-hidden text-center py-8 px-4">

    <div class="w-full overflow-hidden sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/3 ">
        <div class="w-full">
            Išrašytų sąskaitų suma
        </div>
        <div class="w-full text-4xl">
            {{ $income }} &euro;
        </div>
    </div>

    <div class="w-full overflow-hidden sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/3">
        <div class="w-full">
            Sąnaudų suma
        </div>
        <div class="w-full text-4xl">
            {{ $expenses }} &euro;
        </div>
    </div>

    <div class="w-full overflow-hidden sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/3">
        <div class="w-full" id="taxInfo">
            Mokėtini mokesčiai <svg fill="none" height="14" viewBox="0 0 14 14" width="14" class="inline text-blue-500">
                <path
                    d="M0 7C0 3.16129 3.13306 0 7 0C10.8387 0 14 3.16129 14 7C14 10.8669 10.8387 14 7 14C3.13306 14 0 10.8669 0 7Z"
                    fill="currentColor"></path>
                <path
                    d="M7 2C7.82143 2 8.5 2.64286 8.5 3.42105C8.5 4.23308 7.82143 4.84211 7 4.84211C6.14286 4.84211 5.5 4.23308 5.5 3.42105C5.5 2.64286 6.14286 2 7 2ZM9 10.594C9 10.8308 8.78571 11 8.57143 11H5.42857C5.17857 11 5 10.8308 5 10.594V9.78196C5 9.57895 5.17857 9.37594 5.42857 9.37594H5.85714V7.21053H5.42857C5.17857 7.21053 5 7.04135 5 6.80451V5.99248C5 5.78947 5.17857 5.58647 5.42857 5.58647H7.71429C7.92857 5.58647 8.14286 5.78947 8.14286 5.99248V9.37594H8.57143C8.78571 9.37594 9 9.57895 9 9.78196V10.594Z"
                    fill="white"></path>
            </svg>
        </div>

        <div class="w-full text-4xl">
            {{ $totalTax }} &euro;
        </div>
    </div>
{{--    TODO: Reiktu i local perkelt --}}
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script>
        // With the above scripts loaded, you can call `tippy()` with a CSS
        // selector and a `content` prop:
        tippy('#taxInfo', {
            allowHTML: true,
            content: 'GPM: {{ $gpm }} &euro; <br> PSD: {{ $psd }} &euro;<br>VSD: {{ $vsd }} &euro;',
        });
    </script>
</div>
