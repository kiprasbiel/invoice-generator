<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewUserTest extends TestCase
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

    private function getSettingsArray(string $name): object {
        $settingArr = $this->user->meta()->where('name', $name)->get();
        return json_decode($settingArr[0]->value);
    }

    public function test_if_userActivitySettings_are_created(){
        $setting = $this->getSettingsArray('userActivitySettings');
        $this->assertEquals($this->user->name, $setting->full_name);
        $this->assertEquals($this->user->email, $setting->email);
    }

    public function test_if_sfNumberSettings_are_created(){
        $setting = $this->getSettingsArray('sfNumberSettings');
        $this->assertEquals('SF', $setting->sf_code);
        $this->assertEquals('1', $setting->sf_number);
    }

    public function test_if_privilegesSettings_are_created(){
        $setting = $this->getSettingsArray('privilegesSettings');
        $this->assertEquals('pens0', $setting->additionalPension);
    }

    public function test_if_mail_settings_are_created() {
        $setting = $this->getSettingsArray('mailSettings');
        $this->assertEquals(null, $setting->sender);
    }
}
