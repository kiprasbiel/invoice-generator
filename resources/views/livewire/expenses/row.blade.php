<tr class="bg-white table-row">
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
            <div class="text-sm font-medium text-gray-900">
                {{$expense->created_at->format('Y-m-d')}}
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900">{{$expense->number}}</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{$expense->seller_name}}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{$expense->total_price}} &euro;
    </td>
</tr>
