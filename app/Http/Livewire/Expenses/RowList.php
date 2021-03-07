<?php

namespace App\Http\Livewire\Expenses;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class RowList extends Component
{
    public Model $expense;
    public Collection $items;

    public string $display;

    protected function getListeners(): array {
        $listenerName = 'getExpense-' . $this->expense->id;
        return [$listenerName => 'getExpense'];
    }

    private function setDisplayState(bool $state) {
        $this->display = ($state) ? 'table-row' : 'hidden';
    }

    public function mount($expense) {
        $this->display = 'hidden';
        $this->expense = $expense;
    }

    // Used for listeners
    public function getExpense($state) {
        $this->items = $this->expense->items; // ?
        $this->setDisplayState($state);
    }

    public function delete() {
        $this->display = 'hidden';
        $this->emit('delete-' . $this->expense->id);
    }

    public function render() {
        return view('livewire.expenses.row-list');
    }
}
