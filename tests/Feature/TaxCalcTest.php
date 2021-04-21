<?php

namespace Tests\Feature;

use App\Models\Meta;
use App\Models\Taxes\GPM;
use App\Models\Taxes\SodraTaxes\PSD;
use App\Models\Taxes\SodraTaxes\VSD;
use App\Models\User;
use Tests\TestCase;


/*
 * Duomenys tikrinti Sodra skaiciuokleje:
 * 2021-01-19
 */

class TaxCalcTest extends TestCase
{
    protected $user;

    protected function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    protected function setUserPrivileges(string $pri): void {
        switch ($pri) {
            case 'low':
                $value = '{"isStudent":null,"isFirstTimer":null,"isPensioner":null,"additionalPension":"pens21","isFreeMarketActivity":null}';
                break;
            case 'high':
                $value = '{"isStudent":null,"isFirstTimer":null,"isPensioner":null,"additionalPension":"pens3","isFreeMarketActivity":null}';
                break;
            default:
                $value = '{"isStudent":null,"isFirstTimer":null,"isPensioner":null,"additionalPension":"pens0","isFreeMarketActivity":null}';
                break;
        }

        Meta::where('name', 'privilegesSettings')
            ->where('metable_type', 'App\Models\User')
            ->where('metable_id', $this->user->id)
            ->update([
                'value' => $value
            ]);
    }

    /*
     * GPM
     *
     * Duomenys tikrinti Sodra skaiciuokleje:
     * 2021-04-12
     *
     * Naujos GPM formules: https://auditors.lt/gpm-formule-2018m/
     */
    public function testGPMCalc10000_100() {
        $gpm = new GPM(10000, 100);
        $this->assertEquals(350, $gpm->getCalcGPM());
    }

    public function testGPMCalc10000_4000() {
        $gpm = new GPM(10000, 4000);
        $this->assertEquals(239.31, $gpm->getCalcGPM());
    }

    public function testGPMCalc24000_0() {
        $gpm = new GPM(24000, 0);
        $this->assertEquals(840.00, $gpm->getCalcGPM());
    }

    public function testGPMCalc30000_0() {
        $gpm = new GPM(30000, 0);
        $this->assertEquals(1190.00, $gpm->getCalcGPM());
    }

    public function testGPMCalc60000_0() {
        $gpm = new GPM(60000, 0);
        $this->assertEquals(6300.00, $gpm->getCalcGPM());
    }

    public function testGPMCalc100000_0() {
        $gpm = new GPM(100000, 0);
        $this->assertEquals(10500.00, $gpm->getCalcGPM());
    }

    public function testGPMCalc200000_0() {
        $gpm = new GPM(200000, 0);
        $this->assertEquals(21000.00, $gpm->getCalcGPM());
    }

    /*
     * PSD
     *
     * Duomenys tikrinti Sodra skaiciuokleje:
     * 2021-04-12
     */
    public function testPSDCalc10000_100() {
        $psd = new PSD(10000, 100);
        $this->assertEquals(537.72, $psd->getCalcPSD());
    }

    public function testPSDCalc10000_4000() {
        $psd = new PSD(10000, 4000);
        $this->assertEquals(537.72, $psd->getCalcPSD());
    }

    public function testPSDCalc24000_0() {
        $psd = new PSD(24000, 0);
        $this->assertEquals(1055.38, $psd->getCalcPSD());
    }

    public function testPSDCalc30000_0() {
        $psd = new PSD(30000, 0);
        $this->assertEquals(1319.22, $psd->getCalcPSD());
    }

    public function testPSDCalc60000_0() {
        $psd = new PSD(60000, 0);
        $this->assertEquals(2638.44, $psd->getCalcPSD());
    }

    public function testPSDCalc100000_0() {
        $psd = new PSD(100000, 0);
        $this->assertEquals(4059.99, $psd->getCalcPSD());
    }

    public function testPSDCalc200000_0() {
        $psd = new PSD(200000, 0);
        $this->assertEquals(4059.99, $psd->getCalcPSD());
    }

    /*
     * VSD
     */

    public function testVSDCalc10000_100() {
        $vsd = new VSD(10000, 100);
        $this->assertEquals(788.76, $vsd->getCalcVSD());
    }

    public function testVSDCalc10000_4000() {
        $vsd = new VSD(10000, 4000);
        $this->assertEquals(676.08, $vsd->getCalcVSD());
    }

    public function testVSDCalc24000_0() {
        $vsd = new VSD(24000, 0);
        $this->assertEquals(1893.02, $vsd->getCalcVSD());
    }

    public function testVSDCalc30000_0() {
        $vsd = new VSD(30000, 0);
        $this->assertEquals(2366.28, $vsd->getCalcVSD());
    }

    public function testVSDCalc60000_0() {
        $vsd = new VSD(60000, 0);
        $this->assertEquals(4732.56, $vsd->getCalcVSD());
    }

    public function testVSDCalc100000_0() {
        $vsd = new VSD(100000, 0);
        $this->assertEquals(7282.40, $vsd->getCalcVSD());
    }

    public function testVSDCalc200000_0() {
        $vsd = new VSD(200000, 0);
        $this->assertEquals(7282.40, $vsd->getCalcVSD());
    }

    /*
     * VSD with low privilege
     *
     * Duomenys tikrinti Sodra skaiciuokleje:
     * 2021-04-21
     *
     */

    public function testVSDCalc10000_100_low_privilege() {
        $this->setUserPrivileges('low');
        $vsd = new VSD(10000, 100);
        $this->assertEquals(939.96, $vsd->getCalcVSD());
    }

    public function testVSDCalc10000_4000_low_privilege() {
        $this->setUserPrivileges('low');
        $vsd = new VSD(10000, 4000);
        $this->assertEquals(805.68, $vsd->getCalcVSD());
    }

    public function testVSDCalc24000_0_low_privilege() {
        $this->setUserPrivileges('low');
        $vsd = new VSD(24000, 0);
        $this->assertEquals(2255.90, $vsd->getCalcVSD());
    }

    public function testVSDCalc30000_0_low_privilege() {
        $this->setUserPrivileges('low');
        $vsd = new VSD(30000, 0);
        $this->assertEquals(2819.88, $vsd->getCalcVSD());
    }

    public function testVSDCalc60000_0_low_privilege() {
        $this->setUserPrivileges('low');
        $vsd = new VSD(60000, 0);
        $this->assertEquals(5639.76, $vsd->getCalcVSD());
    }

    public function testVSDCalc100000_0_low_privilege() {
        $this->setUserPrivileges('low');
        $vsd = new VSD(100000, 0);
        $this->assertEquals(8678.38, $vsd->getCalcVSD());
    }

    public function testVSDCalc200000_0_low_privilege() {
        $this->setUserPrivileges('low');
        $vsd = new VSD(200000, 0);
        $this->assertEquals(8678.38, $vsd->getCalcVSD());
    }

    /*
     * VSD with high privilege
     *
     * Duomenys tikrinti Sodra skaiciuokleje:
     * 2021-04-21
     *
     */

    public function testVSDCalc10000_100_high_privilege() {
        $this->setUserPrivileges('high');
        $vsd = new VSD(10000, 100);
        $this->assertEquals(977.76, $vsd->getCalcVSD());
    }

    public function testVSDCalc10000_4000_high_privilege() {
        $this->setUserPrivileges('high');
        $vsd = new VSD(10000, 4000);
        $this->assertEquals(838.08, $vsd->getCalcVSD());
    }

    public function testVSDCalc24000_0_high_privilege() {
        $this->setUserPrivileges('high');
        $vsd = new VSD(24000, 0);
        $this->assertEquals(2346.62, $vsd->getCalcVSD());
    }

    public function testVSDCalc30000_0_high_privilege() {
        $this->setUserPrivileges('high');
        $vsd = new VSD(30000, 0);
        $this->assertEquals(2933.28, $vsd->getCalcVSD());
    }

    public function testVSDCalc60000_0_high_privilege() {
        $this->setUserPrivileges('high');
        $vsd = new VSD(60000, 0);
        $this->assertEquals(5866.56, $vsd->getCalcVSD());
    }

    public function testVSDCalc100000_0_high_privilege() {
        $this->setUserPrivileges('high');
        $vsd = new VSD(100000, 0);
        $this->assertEquals(9027.38, $vsd->getCalcVSD());
    }

    public function testVSDCalc200000_0_high_privilege() {
        $this->setUserPrivileges('high');
        $vsd = new VSD(200000, 0);
        $this->assertEquals(9027.38, $vsd->getCalcVSD());
    }

    protected function tearDown(): void {
        parent::tearDown();

        $this->user = NULL;
    }
}
