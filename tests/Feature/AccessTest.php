<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_redirect_for_login() {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_open_register_and_login_pages() {
        $response = $this->get('/login');
        $response->assertOk();
        $response->assertSee('Registruotis');

        $response = $this->get('/register');
        $response->assertOk();
        $response->assertSee('Prisijungti');
    }

    public function test_login_and_see_dashboard() {
        $response = $this->actingAs(User::factory()->create());
        $response->assertAuthenticated();

        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('Išrašytų sąskaitų suma');
        $response->assertSee('Sąnaudų suma');
        $response->assertSee('Mokėtini mokesčiai');

        $response->assertSee('GPM');
        $response->assertSee('VSD');
        $response->assertSee('PSD');
    }
}
