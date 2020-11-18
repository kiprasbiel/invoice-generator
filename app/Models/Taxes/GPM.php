<?php


namespace App\Models\Taxes;

use App\Models\Tax;

class GPM extends Tax
{
    protected $rate;

    function __construct($income, $expenses)
    {
        parent::__construct($income, $expenses);
        $this->rate = 0.05; // TODO: perkelti i DB. Gali buti 15% arba 5%
    }

    public function getCalcGPM()
    {
        return round($this->getPayableWage() * $this->rate, 2);
    }
}
