<?php


namespace App\Models\Taxes\SodraTaxes;

use App\Models\Taxes\SodraTax;

class PSD extends SodraTax
{
    protected $rate;
    protected $minimalWage;
    protected $hasPrivilege;

    function __construct($income, $expenses, $privilege = false) {
        parent::__construct($income, $expenses);
        $this->rate = 0.0698; // TODO: perkelti i DB

        $this->minimalWage = 607; // TODO: perkelti i DB

        $this->hasPrivilege = $privilege;
    }

    protected function calcMinimalPSD() {
        $monthly = round($this->minimalWage * $this->rate, 2);
        return $monthly * 12;
    }

    protected function calcStandardPSD() {
        return $this->calcPayableProfit() * $this->rate;
    }

    public function getCalcPSD() {
        if($this->calcStandardPSD() >= $this->calcMinimalPSD()) {
            return round($this->calcStandardPSD(), 2);
        } else {
            return round($this->calcMinimalPSD(), 2);
        }
    }
}
