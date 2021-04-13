<?php


namespace App\Models\Taxes\SodraTaxes;

use App\Models\Taxes\SodraTax;

class VSD extends SodraTax
{
    protected $rate;

    protected $maximumPayableTax;
    protected $firstTimer;

    protected $user;

    function __construct($income, $expenses, $firstTimer = false)
    {
        parent::__construct($income, $expenses);
        $this->rate = 0.1252; // TODO: perkelti i DB

        $this->firstTimer = $firstTimer;

        $this->maximumPayableTax = 7282.4; // TODO: Perkelti i DB. Gali buti 7282.4, 8678.38, 9027.38

        $this->user = auth()->user();
    }

    private function getRetirementRate(){
//        $user = auth()->user();
        $rate = $this->user->getPrivilege('additionalPension');
        switch($rate){
            case 'pens21':
                return 0.024;
            case 'pens3':
                return 0.03;
            default:
                return 0;
        }
    }

    private function isFirstTimer(){
        if($this->user->getPrivilege('isFirstTimer') === 'yes'){
            return true;
        }
        return false;
    }

    protected function calcVSDRate()
    {
        return $this->rate + $this->getRetirementRate();
    }

    protected function calcVSD()
    {
        return round($this->calcPayableProfit() * $this->calcVSDRate(), 2);
    }

    public function getCalcVSD()
    {
        if ($this->isFirstTimer()) {
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
