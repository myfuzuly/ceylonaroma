<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name'                  => 'Jane Doe',
            'email'                 => 'jane@example.com',
            'password'              => 'Password1!',
            'password_confirmation' => 'Password1!',
            'country'               => 'United Kingdom',
            '_hp'                   => '',
            'captcha'               => '5',
        ], $overrides);
    }

    private function withCaptcha(int $answer = 5): static
    {
        session(['captcha_ans' => $answer]);
        return $this;
    }

    /** GET /account/register shows form */
    public function test_registration_page_loads(): void
    {
        $response = $this->get(route('customer.register'));
        $response->assertStatus(200);
        $response->assertSee('Register');
    }

    /** Honeypot filled → blocked */
    public function test_honeypot_blocks_bot(): void
    {
        $this->withCaptcha(5);
        $response = $this->post(route('customer.register.post'), $this->validPayload(['_hp' => 'bot']));
        $response->assertRedirect(route('customer.register'));
        $this->assertDatabaseMissing('customers', ['email' => 'jane@example.com']);
    }

    /** Wrong CAPTCHA → back with error */
    public function test_wrong_captcha_fails(): void
    {
        $this->withCaptcha(5);
        $response = $this->post(route('customer.register.post'), $this->validPayload(['captcha' => '9']));
        $response->assertRedirect();
        $response->assertSessionHas('captcha_error');
        $this->assertDatabaseMissing('customers', ['email' => 'jane@example.com']);
    }

    /** Correct CAPTCHA + valid data → account created */
    public function test_successful_registration(): void
    {
        $this->withCaptcha(5);
        $response = $this->post(route('customer.register.post'), $this->validPayload());
        $response->assertRedirect(route('customer.dashboard'));
        $this->assertDatabaseHas('customers', ['email' => 'jane@example.com']);
        $this->assertNotNull(Customer::where('email', 'jane@example.com')->value('password'));
    }

    /** Duplicate email → validation error */
    public function test_duplicate_email_rejected(): void
    {
        $this->customer(['email' => 'jane@example.com']);
        $this->withCaptcha(5);
        $response = $this->post(route('customer.register.post'), $this->validPayload());
        $response->assertSessionHasErrors('email');
    }

    /** Password too short → validation error */
    public function test_short_password_rejected(): void
    {
        $this->withCaptcha(5);
        $response = $this->post(route('customer.register.post'), $this->validPayload([
            'password'              => 'abc',
            'password_confirmation' => 'abc',
        ]));
        $response->assertSessionHasErrors('password');
    }

    /** Rate limiting: 8 attempts per 10 min */
    public function test_rate_limit_applied(): void
    {
        $this->withCaptcha(5);
        for ($i = 0; $i < 8; $i++) {
            $this->post(route('customer.register.post'), $this->validPayload([
                'email' => "bot{$i}@example.com",
                'captcha' => '999',
            ]));
        }
        $response = $this->post(route('customer.register.post'), $this->validPayload(['captcha' => '999']));
        $response->assertStatus(429);
    }
}
