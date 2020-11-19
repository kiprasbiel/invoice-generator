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
        <div class="w-full">
            Mokėtini mokesčiai
        </div>
        <div class="w-full text-4xl">
            {{ $totalTax }} &euro;
        </div>
    </div>

</div>
