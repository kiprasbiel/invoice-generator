<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UITest extends TestCase
{
    public function testCanSeeDashboard(){
        $this->actingAs(User::factory()->create());

        $response = $this->get('/');

        $response->assertSee('Išrašytų sąskaitų suma');
        $response->assertSee('Sąnaudų suma');
        $response->assertSee('Mokėtini mokesčiai');

        $response->assertSee('GPM');
        $response->assertSee('VSD');
        $response->assertSee('PSD');
    }
}
