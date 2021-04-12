<?php

namespace Tests\Feature;

use App\Models\Taxes\GPM;
use App\Models\Taxes\SodraTaxes\PSD;
use App\Models\Taxes\SodraTaxes\VSD;
use App\Models\User;
use Tests\TestCase;


/*
 * Duomenys tikrinti Sodra skaiciuokleje:
 * 2021-01-19
 *
 * TODO: blogai veikia islaidu iskaiciavimas
 * TODO: Perrasyt GPM formules ivertinant visas 3 pakopas
 * TODO: Perrasyt PSD formules. Neveikia nuo 100k
 */

class TaxCalcTest extends TestCase
{
    protected $user;

    protected function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /*
     * Duomenys tikrinti Sodra skaiciuokleje:
     * 2021-04-12
     *
     * Naujos GPM formules: https://auditors.lt/gpm-formule-2018m/
     */
    public function testGPMCalc() {
        $gpm = new GPM(10000, 100);
        $this->assertEquals(350, $gpm->getCalcGPM());

        $gpm = new GPM(10000, 4000);
        $this->assertEquals(239.31, $gpm->getCalcGPM());

        $gpm = new GPM(24000, 0);
        $this->assertEquals(840.00, $gpm->getCalcGPM());

        $gpm = new GPM(30000, 0);
        $this->assertEquals(1190.00, $gpm->getCalcGPM());

        $gpm = new GPM(60000, 0);
        $this->assertEquals(6300.00, $gpm->getCalcGPM());

        $gpm = new GPM(100000, 0);
        $this->assertEquals(10500.00, $gpm->getCalcGPM());

        $gpm = new GPM(200000, 0);
        $this->assertEquals(21000.00, $gpm->getCalcGPM());
    }

    /*
     * Duomenys tikrinti Sodra skaiciuokleje:
     * 2021-04-12
     */
    public function testPSDCalc() {
        $psd = new PSD(10000, 100);
        $this->assertEquals(537.72, $psd->getCalcPSD());

        $psd = new PSD(10000, 4000);
        $this->assertEquals(537.72, $psd->getCalcPSD());

        $psd = new PSD(24000, 0);
        $this->assertEquals(1055.38, $psd->getCalcPSD());

        $psd = new PSD(30000, 0);
        $this->assertEquals(1319.22, $psd->getCalcPSD());

        $psd = new PSD(60000, 0);
        $this->assertEquals(2638.44, $psd->getCalcPSD());

        $psd = new PSD(100000, 0);
        $this->assertEquals(4059.99, $psd->getCalcPSD());

        $psd = new PSD(200000, 0);
        $this->assertEquals(4059.99, $psd->getCalcPSD());
    }

    public function testVSDCalc() {
        $vsd = new VSD(10000, 100);
        $this->assertEquals(788.76, $vsd->getCalcVSD());

        $vsd = new VSD(10000, 4000);
        $this->assertEquals(676.08, $vsd->getCalcVSD());

        $vsd = new VSD(24000, 0);
        $this->assertEquals(1893.02, $vsd->getCalcVSD());

        $vsd = new VSD(30000, 0);
        $this->assertEquals(2366.28, $vsd->getCalcVSD());

        $vsd = new VSD(60000, 0);
        $this->assertEquals(4732.56, $vsd->getCalcVSD());

        $vsd = new VSD(100000, 0);
        $this->assertEquals(7282.40, $vsd->getCalcVSD());

        $vsd = new VSD(200000, 0);
        $this->assertEquals(7282.40, $vsd->getCalcVSD());
    }

    protected function tearDown(): void {
        parent::tearDown();

        $this->user = NULL;
    }
}
