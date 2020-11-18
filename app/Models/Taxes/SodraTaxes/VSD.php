<?php


namespace App\Models\Taxes\SodraTaxes;

use App\Models\Taxes\SodraTax;

class VSD extends SodraTax
{
    protected $rate;

    protected $retirementRate;
    protected $maximumPayableTax;
    protected $firstTimer;

    function __construct($income, $expenses, $firstTimer = false)
    {
        parent::__construct($income, $expenses);
        $this->rate = 0.1252; // TODO: perkelti i DB

        $this->retirementRate = 0; // TODO: perkelti i db. Gali buti 0 arba 2.1% arba 3%
        $this->firstTimer = $firstTimer;

        $this->maximumPayableTax = 6683.20; // TODO: Perkelti i DB. Gali buti 6683.20, 7804.19, 8284.61
    }

    protected function calcVSDRate()
    {
        return $this->rate + $this->retirementRate;
    }

    protected function calcVSD()
    {
        return $this->calcPayableProfit() * $this->calcVSDRate();
    }

    public function getCalcVSD()
    {
        if ($this->firstTimer) {
            return 0;
        }
        // Aiskiau issiaiskinti, kokios tos VSD lengvatos
        elseif ($this->maximumPayableTax >= $this->calcVSD()) {
            return $this->calcVSD();
        }
        else {
            return $this->maximumPayableTax;
        }
    }

}
