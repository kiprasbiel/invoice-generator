<?php

namespace App\Models;

class Tax
{
    protected $income;
    protected $expenses;

    function __construct($income, $expenses)
    {
        $this->income = $income;
        $this->expenses = $expenses;
    }

    private function calcDefaultExpenses(){
        return $this->income * 0.3; // TODO: Perkelt i DB
    }

    // Pelno apskaiciavimas
    protected function getPayableWage(){
        if($this->expenses > $this->calcDefaultExpenses()){
            return $this->income - $this->expenses;
        }
        else{
            return $this->income - $this->calcDefaultExpenses();
        }
    }
}
