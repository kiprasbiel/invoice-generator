<?php

namespace Tests\Feature;

use App\Models\Taxes\GPM;
use App\Models\Taxes\SodraTaxes\PSD;
use App\Models\Taxes\SodraTaxes\VSD;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

    public function testGPMCalc() {
        $gpm = new GPM(10000, 100);
        $this->assertEquals(350, $gpm->getCalcGPM());

        $gpm = new GPM(10000, 4000);
        $this->assertEquals(240.77, $gpm->getCalcGPM());
    }

    public function testPSDCalc() {
        $psd = new PSD(10000, 100);
        $this->assertEquals(508.44, $psd->getCalcPSD());

        $psd = new PSD(10000, 4000);
        $this->assertEquals(508.44, $psd->getCalcPSD());
    }

    public function testVSDCalc() {
        $vsd = new VSD(10000, 100);
        $this->assertEquals(788.76, $vsd->getCalcVSD());

        $vsd = new VSD(10000, 4000);
        $this->assertEquals(676.08, $vsd->getCalcVSD());
    }

    protected function tearDown(): void {
        parent::tearDown();

        $this->user = NULL;
    }
}
