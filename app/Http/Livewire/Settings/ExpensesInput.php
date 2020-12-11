<?php

namespace App\Http\Livewire\Settings;

use App\Models\Meta;
use Livewire\Component;

class ExpensesInput extends Component
{
    public $expenses;

    protected $rules = [
        'expenses' => 'nullable|numeric'
    ];

    protected $messages = [
        'expenses.numeric' => 'Išlaidos gali būti įvestos tik skaičiais',
    ];

    public function render()
    {
        return view('livewire.settings.expenses-input');
    }

    public function mount(){
        $user = auth()->user();

        $this->expenses = $user->getTotalExpenses();
    }

    public function submit(){
        $data = $this->validate();
        $jsonData = json_encode($data);
        $user = auth()->user();

        $user->meta()->updateOrCreate(
            ['name' => 'totalExpenses'],
            ['value' => $jsonData]
        );
    }
}
