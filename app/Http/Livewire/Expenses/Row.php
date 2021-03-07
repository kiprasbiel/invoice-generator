<?php

namespace App\Http\Livewire\Expenses;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Row extends Component
{
    public Model $expense;
    public $display;
    public $backgroundColor;
    public $shadow;
    public $displayH;

    public $hamburger;
    public $closeSection;


    protected function getListeners(): array {
        $listenerName = 'delete-' . $this->expense->id;
        return [$listenerName => 'removeRow'];
    }

    public function mount(Model $expense) {
        $this->expense = $expense;
        $this->display = false;
        $this->backgroundColor = 'bg-white';
        $this->shadow = 'shadow-none';
        $this->hamburger = 'inline-flex';
        $this->closeSection = 'hidden';
        $this->displayH = 'table-row';
    }

    public function render() {
        return view('livewire.expenses.row');
    }

    private function setBackgroundColor() {
        if($this->display) {
            $this->backgroundColor = 'bg-gray-100';
            $this->shadow = 'shadow-inner';
            $this->hamburger = 'hidden';
            $this->closeSection = 'inline-flex';
        } else {
            $this->backgroundColor = 'bg-white';
            $this->shadow = 'shadow-none';
            $this->hamburger = 'inline-flex';
            $this->closeSection = 'hidden';
        }
    }

    public function showExpense($id) {
        $expense = Expense::find($id);
        $this->expense = $expense;
        $this->display = !$this->display;
        $this->setBackgroundColor();
        $this->emit('getExpense-' . $this->expense->id, $this->display);
    }

    public function removeRow() {
        $this->display = !$this->display;
        $this->setBackgroundColor();
        $this->displayH = 'hidden';
        $this->expense->delete();

        $this->dispatchBrowserEvent('notify', $this->newNotification('Išlaida sėkmingai pašalinta'));
    }
}
