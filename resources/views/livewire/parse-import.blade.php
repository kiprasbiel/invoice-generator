<form wire:submit.prevent="startImport({{$importId}})">
    <x-jet-dialog-modal wire:model="show" maxWidth="7xl">>

        <x-slot name="title">
            <h2>Importas</h2>
        </x-slot>

        <x-slot name="content">
            <div class="pb-5">
                <h4>Nurodykite, kurie importuojamo failo stulpeliai atitinka duomenų bazės stulpelius</h4>
            </div>
            <div>
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($csvData as $row)
                                        <tr>
                                            @foreach($row as $col)
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{$col}}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    <tr>
                                        @if($csvData)
                                            @foreach ($csvData[0] as $key => $value)
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <select wire:model.defer="fields.{{$key}}" name="fields[{{ $key }}]"
                                                            class="mt-1 block py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                        <option value="null">Neimportuoti</option>
                                                        @foreach ($dbColNames as $db_field)
                                                            <option value="{{ $db_field }}">{{ $db_field }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            @endforeach
                                        @endif
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('show')" wire:loading.attr="disabled">
                Atšaukti
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" type="submit" wire:loading.attr="disabled">
                Pradėti importą
            </x-jet-danger-button>
        </x-slot>

    </x-jet-dialog-modal>
</form>
