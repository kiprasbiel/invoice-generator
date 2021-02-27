<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    private function login() {
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

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
        $this->login();
        $response = $this->get('/');
        $response->assertOk();
    }

    public function test_cant_access_expenses_without_login() {
        $response = $this->get('/expenses');
        $response->assertStatus(302);
    }

    public function test_can_access_expenses_with_login() {
        $this->login();

        $response = $this->get('/expenses');
        $response->assertOk();
    }
}
