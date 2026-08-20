<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Product;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function adminUser(): User
    {
        return User::create([
            'name'     => 'Admin',
            'email'    => 'admin@ceylonaroma.com',
            'password' => bcrypt('Admin@2024'),
            'role'     => 'admin',
        ]);
    }

    protected function customer(array $attrs = []): Customer
    {
        return Customer::create(array_merge([
            'name'      => 'Test Customer',
            'email'     => 'customer@test.com',
            'password'  => bcrypt('Password1!'),
            'country'   => 'Australia',
            'is_active' => true,
        ], $attrs));
    }

    protected function category(string $name = 'Spices'): Category
    {
        static $count = 0;
        $count++;
        return Category::create([
            'name'   => $name . ($count > 1 ? " $count" : ''),
            'slug'   => \Illuminate\Support\Str::slug($name) . ($count > 1 ? "-$count" : ''),
            'status' => true,
        ]);
    }

    protected function product(array $attrs = []): Product
    {
        $cat = Category::first() ?? $this->category();
        return Product::create(array_merge([
            'name'        => 'Test Cinnamon ' . uniqid(),
            'slug'        => 'test-cinnamon-' . uniqid(),
            'category_id' => $cat->id,
            'status'      => true,
        ], $attrs));
    }

    protected function loginAdmin(): static
    {
        $admin = $this->adminUser();
        $this->withSession([
            'admin_logged_in' => true,
            'admin_name'      => $admin->name,
            'admin_email'     => $admin->email,
        ]);
        return $this;
    }

    protected function loginCustomer(?Customer $c = null): static
    {
        $c = $c ?? $this->customer();
        $this->withSession([
            'customer_id'    => $c->id,
            'customer_name'  => $c->name,
            'customer_email' => $c->email,
        ]);
        return $this;
    }
}
