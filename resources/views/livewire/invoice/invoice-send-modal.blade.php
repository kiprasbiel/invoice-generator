<form wire:submit.prevent="send">
    <x-jet-dialog-modal wire:model="show" maxWidth="xl">>

        <x-slot name="title">
            <h2>Sąskaitos <b>{{$invoice['sf_code'] ?? ''}}</b> siuntimas el. paštu.</h2>
        </x-slot>

        <x-slot name="content">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="receiver">
                    Gavėjas
                </label>
                <input wire:model.defer="receiver"
                       class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       id="receiver" type="text" placeholder="vardas@domenas.lt">
                @error('receiver') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="headline">
                    Antraštė
                </label>
                <input wire:model.defer="headline"
                       class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       id="headline" type="text" placeholder="Jūsų antraštė">
                @error('headline') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-xs font-bold mb-2" for="messageBody">
                    Turinys
                </label>
                <textarea wire:model.defer="messageBody"
                       class="appearance-none block w-full border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       id="messageBody" rows="5" placeholder="Jūsų žinutė"></textarea>
                @error('messageBody') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-button class="ml-2" type="submit" wire:loading.attr="disabled">
                Siųsti
            </x-jet-button>
        </x-slot>

    </x-jet-dialog-modal>
</form>
