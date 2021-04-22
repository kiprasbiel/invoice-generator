<?php


namespace App\Models\Taxes;

use App\Models\Tax;
use App\Models\Taxes\SodraTaxes\PSD;
use App\Models\Taxes\SodraTaxes\VSD;
use Illuminate\Contracts\Auth\Authenticatable;

class GPM extends Tax
{
    private float $rate;
    private ?Authenticatable $user;

    function __construct($income, $expenses) {
        parent::__construct($income, $expenses);
        $this->user = auth()->user();
    }

    protected function getPayableWage() {
        $psd = new PSD($this->income, $this->expenses);
        $vsd = new VSD($this->income, $this->expenses);

        if($this->expenses + $psd->getCalcPSD() + $vsd->getCalcVSD() > $this->calcDefaultExpenses()) {
            return $this->income - $this->expenses - $psd->getCalcPSD() - $vsd->getCalcVSD();
        } else {
            return $this->income - $this->calcDefaultExpenses();
        }
    }

    private function setGPMRate() {
        $isFreeMarket = $this->user->getPrivilege('isFreeMarketActivity');
        if($isFreeMarket === 'yes' || $this->getPayableWage() > 35000) {
            $this->rate = 0.15;
        } elseif($this->getPayableWage() <= 20000) {
            $this->rate = 0.05;
        } elseif($this->getPayableWage() > 20000 && $this->getPayableWage() <= 35000) {
            $this->rate = 0.15 - (0.1 - 2 / 300000 * ($this->getPayableWage() - 20000));
        }
    }

    public function getCalcGPM(): float {
        $this->setGPMRate();

        return max(round($this->getPayableWage() * $this->rate, 2), 0);
    }
}
