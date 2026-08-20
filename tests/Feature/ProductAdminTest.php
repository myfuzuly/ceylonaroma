<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductAdminTest extends TestCase
{
    use RefreshDatabase;

    /** Product index loads */
    public function test_product_index_loads(): void
    {
        $this->loginAdmin();
        $this->get(route('admin.products.index'))->assertStatus(200);
    }

    /** Create form loads */
    public function test_create_form_loads(): void
    {
        $this->loginAdmin();
        $this->get(route('admin.products.create'))->assertStatus(200)->assertSee('Product Details');
    }

    /** Product created with valid data */
    public function test_product_can_be_created(): void
    {
        $this->loginAdmin();
        $cat = $this->category('Spices');

        $response = $this->post(route('admin.products.store'), [
            'name'        => 'Black Pepper Whole',
            'category_id' => $cat->id,
            'status'      => 1,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['name' => 'Black Pepper Whole']);
    }

    /** Slug auto-generated on create */
    public function test_slug_auto_generated(): void
    {
        $this->loginAdmin();
        $cat = $this->category();

        $this->post(route('admin.products.store'), [
            'name'        => 'Ceylon Green Tea',
            'category_id' => $cat->id,
            'status'      => 1,
        ]);

        $this->assertDatabaseHas('products', ['slug' => 'ceylon-green-tea']);
    }

    /** Edit form loads for existing product */
    public function test_edit_form_loads(): void
    {
        $this->loginAdmin();
        $p = $this->product();

        $this->get(route('admin.products.edit', $p))->assertStatus(200)->assertSee('Product Details');
    }

    /** Product updated successfully */
    public function test_product_can_be_updated(): void
    {
        $this->loginAdmin();
        $p = $this->product();

        $response = $this->put(route('admin.products.update', $p), [
            'name'   => 'Updated Cinnamon Name',
            'status' => 1,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['id' => $p->id, 'name' => 'Updated Cinnamon Name']);
    }

    /** Product deleted */
    public function test_product_can_be_deleted(): void
    {
        $this->loginAdmin();
        $p = $this->product();
        $id = $p->id;

        $this->delete(route('admin.products.destroy', $p));
        $this->assertDatabaseMissing('products', ['id' => $id]);
    }

    /** Image can be uploaded on product create */
    public function test_product_image_upload(): void
    {
        Storage::fake('public');
        $this->loginAdmin();
        $cat = $this->category();

        $this->post(route('admin.products.store'), [
            'name'        => 'Clove Whole',
            'category_id' => $cat->id,
            'status'      => 1,
            'image'       => UploadedFile::fake()->image('clove.jpg', 400, 400),
        ]);

        $product = Product::where('name', 'Clove Whole')->first();
        $this->assertNotNull($product->image);
        Storage::disk('public')->assertExists($product->image);
    }

    /** Remove image flag clears stored image */
    public function test_remove_image_clears_field(): void
    {
        Storage::fake('public');
        $this->loginAdmin();
        $p = $this->product(['image' => 'products/old.jpg']);

        $this->put(route('admin.products.update', $p), [
            'name'         => $p->name,
            'status'       => 1,
            'remove_image' => 1,
        ]);

        $p->refresh();
        $this->assertNull($p->image);
    }

    /** Unauthenticated user cannot create products */
    public function test_guest_cannot_create_product(): void
    {
        $this->post(route('admin.products.store'), ['name' => 'Hack'])->assertRedirect();
        $this->assertDatabaseMissing('products', ['name' => 'Hack']);
    }
}
