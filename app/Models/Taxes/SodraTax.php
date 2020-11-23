<?php


namespace App\Models\Taxes;

use App\Models\Tax;

class SodraTax extends Tax
{
    private $payableWageRate;

    function __construct($income, $expenses)
    {
        parent::__construct($income, $expenses);

        $this->payableWageRate = 0.9; // TODO: Perkelti i DB
    }

    // Suma nuo kurios skaiciuojami Sodros mokesciai
    protected function calcPayableProfit(){
        return round($this->getPayableWage() * $this->payableWageRate, 2);
    }
}
