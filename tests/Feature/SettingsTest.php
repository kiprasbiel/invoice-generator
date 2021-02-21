<?php

namespace Tests\Feature;

use App\Http\Livewire\Settings\SfNumberSettings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $user;

    protected function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    protected function tearDown(): void {
        parent::tearDown();

        $this->user = NULL;
    }

    public function test_settings_can_be_opened() {
        $response = $this->get('/activity');
        $response->assertSee('Veiklos informacija');
    }

    public function test_can_set_invoice_code_prefix() {
        $response = Livewire::test(SfNumberSettings::class)
            ->set('sf_code', 'TT');
        $response->call('submit');
        $response->assertHasNoErrors();

        $meta = $this->user->meta()->where('name', 'sfNumberSettings')->get();
        $this->assertEquals('TT', json_decode($meta[0]->value)->sf_code);
    }
}
