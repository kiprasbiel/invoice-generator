<div>
    <form class="rounded w-full px-20" wire:submit.prevent="{{ $action }}">
        <div class="flex flex-wrap -mx-3 mb-5 mt-4">
            <div class="w-full px-3 mb-6 md:mb-0 text-center text-4xl font-semibold">
                Sąskaita faktūra
            </div>
            <div class="w-full px-3 mb-6 md:mb-0 text-center font-bold">
                Serija ir Nr. {{ $sf_code }}
            </div>
            <div class="w-full px-3 mb-6 md:mb-0 text-center font-bold">
                Sąskaitos data {{ $invoiceDate }}
            </div>
            <div class="flex justify-center w-full px-3 mb-6 mt-3 md:mb-0 items-center">
                <div class="font-bold text-center">
                    <p class="mr-2">Apmokėti iki</p>
                </div>
                <div>
                    <input wire:model.defer="payBy"
                           class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           id="pay_by" type="date">
                    @error('payBy') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="flex flex-wrap mx-3 mb-5 mt-4">
            <div class="w-full md:w-1/2 mb-6 md:mb-0">
                <p class="font-bold">Pardavėjas</p>
                @if($userSettings['full_name'])
                    <div>{{ $userSettings['full_name'] }}</div>
                @endif
                @if($userSettings['iv_code'])
                    <div>Individualios veiklos pažymos nr. {{$userSettings['iv_code']}}</div>
                @endif
                @if($userSettings['vat'])
                    <div>PVM mokėtojo kodas {{$userSettings['vat']}}</div>
                @endif
                @if($userSettings['personal_code'])
                    <div>Asmens kodas {{$userSettings['personal_code']}}</div>
                @endif
                @if($userSettings['address'])
                    <div>{{$userSettings['address']}}</div>
                @endif
                @if($userSettings['phone'])
                    <div>{{$userSettings['phone']}}</div>
                @endif
                @if($userSettings['email'])
                    <div>{{$userSettings['email']}}</div>
                @endif
                @if($userSettings['additional_info'])
                    <div>{{$userSettings['additional_info']}}</div>
                @endif
                @if($userSettings['bank_name'] && $userSettings['bank_account_num'])
                    <div>{{$userSettings['bank_name']}} — {{$userSettings['bank_account_num']}}</div>
                @endif
            </div>

            <div class="w-full md:w-1/2 mb-6 md:mb-0">
                <div>
                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="company_name">
                        Įmonės pavadinimas
                    </label>
                    <input wire:model.defer="companyName"
                           class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           id="company_name" type="text" placeholder="Testas, UAB">
                    @error('companyName') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="company_code">
                        Įmonės kodas
                    </label>
                    <input wire:model.defer="companyCode"
                           class="appearance-none block w-full border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                           id="company_code" type="text" placeholder="123456789">
                    @error('companyCode') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="company_vat">
                        PVM kodas
                    </label>
                    <input wire:model.defer="companyVat"
                           class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           id="company_vat" type="text" placeholder="123456789">
                    @error('companyVat') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="company_address">
                        Įmonės adresas
                    </label>
                    <input wire:model.defer="companyAddress"
                           class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           id="company_address" type="text" placeholder="Vileikos g. 8, Kaunas">
                    @error('companyAddress') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="email">
                        Įmonės el. paštas
                    </label>
                    <input wire:model.defer="email"
                           class="appearance-none block w-full border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                           id="email" type="text" placeholder="info@domenas.lt">
                    @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="py-4">
            <hr>
        </div>

        @foreach($productList as $index => $product)
            <div class="flex flex-wrap -mx-3 mb-5">
                <div class="w-full md:w-1/4 px-3">
                    <label class="block uppercase tracking-wide text-xs font-bold mb-2"
                           for="productList.{{ $index }}.product_name">
                        Paslaugos pavadinimas
                    </label>
                    <input wire:model.defer="productList.{{ $index }}.product_name"
                           name="productList[{{ $index }}][product_name]"
                           class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           id="product_name{{ $index }}" type="text" placeholder="Produktas">
                    @error('productList.' . $index . '.product_name') <span
                        class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div class="flex-1 px-3">
                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="product_price{{ $index }}">
                        Kaina
                    </label>
                    <input wire:model.defer="productList.{{ $index }}.product_price"
                           name="productList[{{ $index }}][product_price]"
                           class="appearance-none block w-full border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                           id="product_price{{ $index }}" type="text" placeholder="125">
                    @error('productList.' . $index . '.product_price') <span
                        class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div class="flex-1 px-3">
                    <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="product_pcs{{ $index }}">
                        Kiekis
                    </label>
                    <input wire:model.defer="productList.{{ $index }}.product_pcs"
                           name="productList[{{ $index }}][product_pcs]"
                           class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           id="product_pcs{{ $index }}" type="text" placeholder="10">
                    @error('productList.' . $index . '.product_pcs') <span
                        class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div class="flex-1 px-3">
                    <label class="block uppercase tracking-wide text-xs font-bold mb-2"
                           for="productList[{{ $index }}][pcs_type]">
                        Vienetai
                    </label>
                    <input wire:model.defer="productList.{{ $index }}.pcs_type"
                           class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           name="productList[{{ $index }}][pcs_type]" type="text">
                    @error('productList.' . $index . '.pcs_type') <span
                        class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div class="flex-1 px-3 mb-auto mt-auto">
                    <div class="text-center">
                        <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-4 rounded"
                                wire:click.prevent="deleteProduct({{ $index }})">Pašalinti
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

        <div>
            <button class="w-10 h-10"
                    wire:click.prevent="addProduct">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     viewBox="0 0 477.867 477.867" style="enable-background:new 0 0 477.867 477.867; fill: #3f83f8;"
                     xml:space="preserve">
<g>
    <g>
        <path d="M392.533,0h-307.2C38.228,0.056,0.056,38.228,0,85.333v307.2c0.056,47.105,38.228,85.277,85.333,85.333h307.2
			c47.105-0.056,85.277-38.228,85.333-85.333v-307.2C477.81,38.228,439.638,0.056,392.533,0z M443.733,392.533
			c0,28.277-22.923,51.2-51.2,51.2h-307.2c-28.277,0-51.2-22.923-51.2-51.2v-307.2c0-28.277,22.923-51.2,51.2-51.2h307.2
			c28.277,0,51.2,22.923,51.2,51.2V392.533z"/>
    </g>
</g>
                    <g>
                        <g>
                            <path d="M324.267,221.867H256V153.6c0-9.426-7.641-17.067-17.067-17.067s-17.067,7.641-17.067,17.067v68.267H153.6
			c-9.426,0-17.067,7.641-17.067,17.067S144.174,256,153.6,256h68.267v68.267c0,9.426,7.641,17.067,17.067,17.067
			S256,333.692,256,324.267V256h68.267c9.426,0,17.067-7.641,17.067-17.067S333.692,221.867,324.267,221.867z"/>
                        </g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
</svg>
            </button>
        </div>

        <div class="float-right mb-4">
            <input class="bg-green-400 hover:bg-green-500 text-white font-bold py-2 px-4 rounded" type="submit"
                   value="Išsaugoti">
        </div>
    </form>
</div>
