<tr class="{{ $display }} list-item-shadow-bottom border-none bg-gray-100">
    <td colspan="5" class="px-4">
        <div>
            <div class="bg-gray-200 p-2 rounded-lg">
                <h5>Produktai</h5>
            </div>
            <table class="min-w-full">
                <thead>
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Pavadinimas
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Vienetai
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kiekis
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kaina
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Suma
                    </th>
                </tr>
                </thead>
                <tbody>
                @if(isset($items))
                    @foreach($items as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{$item->name}}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{$item->unit}}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{$item->quantity}}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{$item->price}} &euro;</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{$item->total_sum}} &euro;</div>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="w-1/3">
            <div class="bg-gray-200 p-2 rounded-lg">
                <h5>Klientas</h5>
            </div>
            <table class="min-w-full">
                <tbody>
                @if($expense->seller_name)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Pavadinimas</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $expense->seller_name}}</div>
                        </td>
                    </tr>
                @endif
                @if($expense->seller_code)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Įmonės kodas</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $expense->seller_code}}</div>
                        </td>
                    </tr>
                @endif
                @if($expense->seller_vat)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">PVM kodas</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $expense->seller_vat}}</div>
                        </td>
                    </tr>
                @endif
                @if($expense->seller_address)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Adresas</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $expense->seller_address}}</div>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div>
            <div class="flex flex-row-reverse p-4 space-x-4 space-x-reverse">
                <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded"
                        wire:click="delete">Ištrinti
                </button>
                <a class="bg-yellow-300 hover:bg-yellow-500 text-white font-bold py-2 px-4 rounded" type="submit"
                   href="{{route('expenses.edit', [$expense->id])}}">Redaguoti</a>
            </div>
        </div>
    </td>
</tr>
