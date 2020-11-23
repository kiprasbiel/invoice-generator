<?php


namespace App\Models\Taxes;

use App\Models\Tax;

class GPM extends Tax
{
    private $rate;

    function __construct($income, $expenses) {
        parent::__construct($income, $expenses);
    }

    private function setGPMRate() {
        $user = auth()->user();
        $isFreeMarket = $user->getPrivilege('isFreeMarketActivity');
        if($isFreeMarket === 'yes') {
            $this->rate = 0.15; // TODO: perkelti i DB. Gali buti 15% arba 5%
        } else {
            $this->rate = 0.05;
        }

    }

    public function getCalcGPM() {
        $this->setGPMRate();
        return round($this->getPayableWage() * $this->rate, 2);
    }
}
