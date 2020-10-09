<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <form class="rounded w-full px-20" wire:submit.prevent="submit">
        <div class="flex flex-wrap -mx-3 mb-5 mt-4">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="company-name">
                    Įmonės pavadinimas
                </label>
                <input wire:model="companyName"
                       class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       id="company-name" type="text" placeholder="Testas, UAB">
                @error('companyName') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-5">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="company-code">
                    Įmonės kodas
                </label>
                <input wire:model="companyCode"
                       class="appearance-none block w-full border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                       id="company-code" type="text" placeholder="123456789">
                @error('companyCode') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div class="w-full md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="company-vat">
                    PVM kodas
                </label>
                <input wire:model="companyVat"
                       class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       id="company-vat" type="text" placeholder="123456789">
                @error('companyVat') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="flex flex-wrap -mx-3">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="company-address">
                    Įmonės adresas
                </label>
                <input wire:model="companyAddress"
                       class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       id="company-address" type="text" placeholder="Vileikos g. 8, Kaunas">
                @error('companyAddress') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="py-4">
            <hr>
        </div>

        @foreach($productList as $index => $product)
            <div class="flex flex-wrap -mx-3 mb-5">
                <div class="w-full md:w-1/4 px-3">
                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="productList.{{ $index }}.product-name">
                        Paslaugos pavadinimas
                    </label>
                    <input wire:model="productList.{{ $index }}.product-name" name="productList[{{ $index }}][product-name]"
                           class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           id="product-name{{ $index }}" type="text" placeholder="Produktas">
                    @error('productList.' . $index . '.product-name') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div class="flex-1 px-3">
                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="product-price{{ $index }}">
                        Kaina
                    </label>
                    <input  wire:model="productList.{{ $index }}.product-price" name="productList[{{ $index }}][product-price]"
                           class="appearance-none block w-full border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                           id="product-price{{ $index }}" type="text" placeholder="125">
                    @error('productList.' . $index . '.product-price') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div class="flex-1 px-3">
                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="product-pcs{{ $index }}">
                        Kiekis
                    </label>
                    <input wire:model="productList.{{ $index }}.product-pcs" name="productList[{{ $index }}][product-pcs]"
                           class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           id="product-pcs{{ $index }}" type="text" placeholder="10">
                    @error('productList.' . $index . '.product-pcs') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div class="flex-1 px-3">
                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="productList[{{ $index }}][pcs-type]">
                        Vienetai
                    </label>
                    <input wire:model="productList.{{ $index }}.pcs-type"
                           class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           name="productList[{{ $index }}][pcs-type]" type="text">
                    @error('productList.' . $index . '.pcs-type') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div class="flex-1 px-3">
                    <button wire:click.prevent="deleteProduct({{ $index }})">Pašalinti</button>
                </div>
            </div>
        @endforeach

        <div>
            <button wire:click.prevent="addProduct">Pridėti produktą</button>
        </div>

        <div class="float-right mb-4">
            <button class="bg-green-400 hover:bg-green-500 text-white font-bold py-2 px-4 rounded" type="submit">
                Generuoti PDF
            </button>
        </div>
    </form>
</div>
