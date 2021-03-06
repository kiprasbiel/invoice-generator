<div>
    <form class="rounded w-full px-20" wire:submit.prevent="create">
        <div class="flex flex-wrap -mx-3 mb-5 mt-4">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="seller_name">
                    Pavadinimas
                </label>
                <input wire:model.defer="sellerName"
                       class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       id="seller_name" type="text" placeholder="Testas, UAB">
                @error('sellerName') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-5">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="seller_code">
                    Įmonės kodas
                </label>
                <input wire:model.defer="sellerCode"
                       class="appearance-none block w-full border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                       id="seller_code" type="text" placeholder="123456789">
                @error('sellerCode') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div class="w-full md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="seller_vat">
                    PVM kodas
                </label>
                <input wire:model.defer="sellerVAT"
                       class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       id="company_vat" type="text" placeholder="123456789">
                @error('sellerVAT') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="flex flex-wrap -mx-3">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="seller_address">
                    Adresas
                </label>
                <input wire:model.defer="sellerAddress"
                       class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       id="seller_address" type="text" placeholder="Vileikos g. 8, Kaunas">
                @error('sellerAddress') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div class="w-full md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="date">
                    Data
                </label>
                <input wire:model.defer="date"
                       class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       id="date" type="date">
                @error('date') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="seller_country">
                    Šalis
                </label>
                <input wire:model.defer="sellerCountry"
                       class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       id="seller_country" type="text" placeholder="Lietuva">
                @error('sellerCountry') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="expense_number">
                    Serijos nr.
                </label>
                <input wire:model.defer="expenseNumber"
                       class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       id="expense_number" type="text" placeholder="SF12345">
                @error('expenseNumber') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div class="w-full md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="currency">
                    Valiuta
                </label>
                <input wire:model.defer="currency"
                       class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       id="currency" type="text">
                @error('currency') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="py-4">
            <hr>
        </div>

        {{--        @foreach($productList as $index => $product)--}}
        {{--            <div class="flex flex-wrap -mx-3 mb-5">--}}
        {{--                <div class="w-full md:w-1/4 px-3">--}}
        {{--                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="productList.{{ $index }}.product_name">--}}
        {{--                        Paslaugos pavadinimas--}}
        {{--                    </label>--}}
        {{--                    <input wire:model.defer="productList.{{ $index }}.product_name" name="productList[{{ $index }}][product_name]"--}}
        {{--                           class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"--}}
        {{--                           id="product_name{{ $index }}" type="text" placeholder="Produktas">--}}
        {{--                    @error('productList.' . $index . '.product_name') <span class="text-red-600">{{ $message }}</span> @enderror--}}
        {{--                </div>--}}
        {{--                <div class="flex-1 px-3">--}}
        {{--                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="product_price{{ $index }}">--}}
        {{--                        Kaina--}}
        {{--                    </label>--}}
        {{--                    <input  wire:model.defer="productList.{{ $index }}.product_price" name="productList[{{ $index }}][product_price]"--}}
        {{--                            class="appearance-none block w-full border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"--}}
        {{--                            id="product_price{{ $index }}" type="text" placeholder="125">--}}
        {{--                    @error('productList.' . $index . '.product_price') <span class="text-red-600">{{ $message }}</span> @enderror--}}
        {{--                </div>--}}
        {{--                <div class="flex-1 px-3">--}}
        {{--                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="product_pcs{{ $index }}">--}}
        {{--                        Kiekis--}}
        {{--                    </label>--}}
        {{--                    <input wire:model.defer="productList.{{ $index }}.product_pcs" name="productList[{{ $index }}][product_pcs]"--}}
        {{--                           class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"--}}
        {{--                           id="product_pcs{{ $index }}" type="text" placeholder="10">--}}
        {{--                    @error('productList.' . $index . '.product_pcs') <span class="text-red-600">{{ $message }}</span> @enderror--}}
        {{--                </div>--}}
        {{--                <div class="flex-1 px-3">--}}
        {{--                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="productList[{{ $index }}][pcs_type]">--}}
        {{--                        Vienetai--}}
        {{--                    </label>--}}
        {{--                    <input wire:model.defer="productList.{{ $index }}.pcs_type"--}}
        {{--                           class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"--}}
        {{--                           name="productList[{{ $index }}][pcs_type]" type="text">--}}
        {{--                    @error('productList.' . $index . '.pcs_type') <span class="text-red-600">{{ $message }}</span> @enderror--}}
        {{--                </div>--}}
        {{--                <div class="flex-1 px-3 mb-auto mt-auto">--}}
        {{--                    <div class="text-center">--}}
        {{--                        <button class=" bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-4  rounded" wire:click.prevent="deleteProduct({{ $index }})">Pašalinti</button>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        @endforeach--}}

        {{--        <div>--}}
        {{--            <button wire:click.prevent="addProduct">Pridėti paslaugą</button>--}}
        {{--        </div>--}}

        <div class="float-right mb-4">
            <input class="bg-green-400 hover:bg-green-500 text-white font-bold py-2 px-4 rounded" type="submit"
                   value="Išsaugoti">
        </div>
    </form>
</div>
