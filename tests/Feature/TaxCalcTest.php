<?php

namespace Tests\Feature;

use App\Models\Taxes\GPM;
use App\Models\Taxes\SodraTaxes\PSD;
use App\Models\Taxes\SodraTaxes\VSD;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
    }

    public function testPSDCalc() {
        $psd = new PSD(10000, 100);
        $this->assertEquals(508.44, $psd->getCalcPSD());
    }

    public function testVSDCalc() {
        $vsd = new VSD(10000, 100);
        $this->assertEquals(788.76, $vsd->getCalcVSD());
    }

    protected function tearDown(): void {
        parent::tearDown();

        $this->user = NULL;
    }
}
