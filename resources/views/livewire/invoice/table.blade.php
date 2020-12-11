<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Data
                        </th>
{{--                        <th scope="col"--}}
{{--                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">--}}
{{--                            Būsena--}}
{{--                        </th>--}}
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Serija, numeris
                        </th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Klientas
                        </th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Suma
                        </th>
                        <th scope="col" class="px-6 py-3 bg-gray-50">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($invoices as $invoice)
                        <livewire:invoice.invoice-list-item :invoice="$invoice" :key="'invoice-' . $invoice->id"/>

                        <livewire:invoice.invoice-info :invoice="$invoice" :key="'invoice-info-' . $invoice->id"/>
                    @endforeach

                    </tbody>

                </table>

                <div class="p-5">
                    {{ $invoices->links('vendor.pagination.tailwind') }}
                </div>


            </div>
        </div>
    </div>
    @if(count($invoices) === 0)
        <div class="text-center py-3">Neturite sukūrę sąskaitų-faktūrų</div>
    @endif
</div>

