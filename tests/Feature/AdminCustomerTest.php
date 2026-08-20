<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCustomerTest extends TestCase
{
    use RefreshDatabase;

    /** Admin customer list loads */
    public function test_index_loads_for_admin(): void
    {
        $this->loginAdmin();
        $this->get(route('admin.customers.index'))->assertStatus(200);
    }

    /** Non-admin redirected away */
    public function test_index_requires_auth(): void
    {
        $this->get(route('admin.customers.index'))->assertRedirect();
    }

    /** Customer detail page */
    public function test_show_customer_detail(): void
    {
        $this->loginAdmin();
        $c = $this->customer();
        $this->get(route('admin.customers.show', $c))->assertStatus(200)->assertSee($c->name);
    }

    /** Disable an active customer */
    public function test_toggle_disables_active_customer(): void
    {
        $this->loginAdmin();
        $c = $this->customer(['is_active' => true]);

        $response = $this->patch(route('admin.customers.toggle', $c));
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $c->refresh();
        $this->assertFalse((bool) $c->is_active);
    }

    /** Re-enable a disabled customer */
    public function test_toggle_enables_disabled_customer(): void
    {
        $this->loginAdmin();
        $c = $this->customer(['is_active' => false]);

        $this->patch(route('admin.customers.toggle', $c));

        $c->refresh();
        $this->assertTrue((bool) $c->is_active);
    }

    /** Delete customer */
    public function test_delete_customer(): void
    {
        $this->loginAdmin();
        $c = $this->customer();
        $id = $c->id;

        $response = $this->delete(route('admin.customers.destroy', $c));
        $response->assertRedirect(route('admin.customers.index'));

        $this->assertDatabaseMissing('customers', ['id' => $id]);
    }

    /** Disabled customer shows "Disabled" badge in index */
    public function test_index_shows_disabled_status(): void
    {
        $this->loginAdmin();
        $this->customer(['email' => 'off@test.com', 'is_active' => false]);

        $this->get(route('admin.customers.index'))->assertSee('Disabled');
    }

    /** Active customer shows "Active" badge */
    public function test_index_shows_active_status(): void
    {
        $this->loginAdmin();
        $this->customer(['email' => 'on@test.com', 'is_active' => true]);

        $this->get(route('admin.customers.index'))->assertSee('Active');
    }

    /** Non-admin cannot delete customer */
    public function test_unauthenticated_cannot_delete(): void
    {
        $c = $this->customer();
        $this->delete(route('admin.customers.destroy', $c))->assertRedirect();
        $this->assertDatabaseHas('customers', ['id' => $c->id]);
    }
}
