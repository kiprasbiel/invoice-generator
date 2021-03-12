<tr class="{{ $backgroundColor }} {{ $shadow }} {{ $displayH }}">
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
            <div class="text-sm font-medium text-gray-900">
                {{$invoice->created_at->format('Y-m-d')}}
            </div>
        </div>
    </td>
{{--    <td class="px-6 py-4 whitespace-nowrap">--}}
{{--                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">--}}
{{--                  Neįntegruota funkcija--}}
    {{--                </span>--}}
    {{--    </td>--}}
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900">{{$invoice->sf_code}}</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{$invoice->company_name}}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{$invoice->total_sum}} &euro;
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <button wire:click="showInvoice({{ $invoice->id }})"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path class="{{ $hamburger }}"
                      stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
                <path class="{{ $closeSection }}" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </td>
</tr>
