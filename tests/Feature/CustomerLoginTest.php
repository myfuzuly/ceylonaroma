<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerLoginTest extends TestCase
{
    use RefreshDatabase;

    /** GET /account/login shows form */
    public function test_login_page_loads(): void
    {
        $this->get(route('customer.login'))->assertStatus(200)->assertSee('Login');
    }

    /** Valid credentials → redirect to dashboard */
    public function test_valid_login_creates_session(): void
    {
        $c = $this->customer(['email' => 'test@example.com', 'password' => 'Password1!']);

        $response = $this->post(route('customer.login.post'), [
            'email'    => 'test@example.com',
            'password' => 'Password1!',
        ]);

        $response->assertRedirect(route('customer.dashboard'));
        $this->assertEquals($c->id, session('customer_id'));
    }

    /** Wrong password → error, no session */
    public function test_wrong_password_fails(): void
    {
        $this->customer(['email' => 'test@example.com', 'password' => 'Password1!']);

        $response = $this->post(route('customer.login.post'), [
            'email'    => 'test@example.com',
            'password' => 'WrongPass!',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertNull(session('customer_id'));
    }

    /** Non-existent email → error */
    public function test_unknown_email_fails(): void
    {
        $response = $this->post(route('customer.login.post'), [
            'email'    => 'nobody@example.com',
            'password' => 'Password1!',
        ]);
        $response->assertSessionHas('error');
        $this->assertNull(session('customer_id'));
    }

    /** Disabled customer → cannot log in */
    public function test_disabled_customer_blocked(): void
    {
        $this->customer(['email' => 'disabled@example.com', 'password' => 'Password1!', 'is_active' => false]);

        $response = $this->post(route('customer.login.post'), [
            'email'    => 'disabled@example.com',
            'password' => 'Password1!',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertNull(session('customer_id'));
    }

    /** Re-enabled customer can log in again */
    public function test_re_enabled_customer_can_login(): void
    {
        $c = $this->customer([
            'email'     => 'reactivated@example.com',
            'password'  => 'Password1!',
            'is_active' => true,
        ]);

        $response = $this->post(route('customer.login.post'), [
            'email'    => 'reactivated@example.com',
            'password' => 'Password1!',
        ]);

        $response->assertRedirect(route('customer.dashboard'));
        $this->assertEquals($c->id, session('customer_id'));
    }

    /** Logout clears session */
    public function test_logout_clears_session(): void
    {
        $c = $this->customer();
        $this->loginCustomer($c);

        $this->post(route('customer.logout'));
        $this->assertNull(session('customer_id'));
    }
}
