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
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sąskaitos numeris
                        </th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pardavėjas
                        </th>
                        <th scope="col"
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Suma
                        </th>
                        <th scope="col" class="px-6 py-3 bg-gray-50">
                            <a class="bg-transparent hover:bg-green-500 text-green-400 hover:text-white font-bold py-2 px-4 border border-green-400 hover:border-transparent rounded"
                               type="submit"
                               href="{{route('expenses.create')}}">Pridėti išlaidas</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($expenses as $expense)
                        <livewire:expenses.row :expense="$expense" :key="'expense-' . $expense->id"/>

                        <livewire:expenses.row-list :expense="$expense" :key="'expense-list-' . $expense->id"/>
                    @endforeach

                    </tbody>

                </table>

                <div class="p-5">
                    {{ $expenses->links('vendor.pagination.tailwind') }}
                </div>


            </div>
        </div>
    </div>
    @if(count($expenses) === 0)
        <div class="text-center py-3">Neturite sukūrę išlaidų</div>
    @endif
</div>

