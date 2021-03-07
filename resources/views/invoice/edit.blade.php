<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h5>ID: {{ $invoice->id }}</h5>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <livewire:invoice-form :invoice="$invoice"/>
            </div>
        </div>
    </div>
</x-app-layout>
