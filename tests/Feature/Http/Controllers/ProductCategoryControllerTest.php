<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProductCategoryController
 */
class ProductCategoryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $productCategories = ProductCategory::factory()->count(3)->create();

        $response = $this->get(route('product-category.index'));

        $response->assertOk();
        $response->assertViewIs('productCategory.index');
        $response->assertViewHas('productCategories');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('product-category.create'));

        $response->assertOk();
        $response->assertViewIs('productCategory.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductCategoryController::class,
            'store',
            \App\Http\Requests\ProductCategoryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $name = $this->faker->name;
        $description = $this->faker->text;
        $status = $this->faker->boolean;

        $response = $this->post(route('product-category.store'), [
            'name' => $name,
            'description' => $description,
            'status' => $status,
        ]);

        $productCategories = ProductCategory::query()
            ->where('name', $name)
            ->where('description', $description)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $productCategories);
        $productCategory = $productCategories->first();

        $response->assertRedirect(route('productCategory.index'));
        $response->assertSessionHas('productCategory.id', $productCategory->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $productCategory = ProductCategory::factory()->create();

        $response = $this->get(route('product-category.show', $productCategory));

        $response->assertOk();
        $response->assertViewIs('productCategory.show');
        $response->assertViewHas('productCategory');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $productCategory = ProductCategory::factory()->create();

        $response = $this->get(route('product-category.edit', $productCategory));

        $response->assertOk();
        $response->assertViewIs('productCategory.edit');
        $response->assertViewHas('productCategory');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductCategoryController::class,
            'update',
            \App\Http\Requests\ProductCategoryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $productCategory = ProductCategory::factory()->create();
        $name = $this->faker->name;
        $description = $this->faker->text;
        $status = $this->faker->boolean;

        $response = $this->put(route('product-category.update', $productCategory), [
            'name' => $name,
            'description' => $description,
            'status' => $status,
        ]);

        $productCategory->refresh();

        $response->assertRedirect(route('productCategory.index'));
        $response->assertSessionHas('productCategory.id', $productCategory->id);

        $this->assertEquals($name, $productCategory->name);
        $this->assertEquals($description, $productCategory->description);
        $this->assertEquals($status, $productCategory->status);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $productCategory = ProductCategory::factory()->create();

        $response = $this->delete(route('product-category.destroy', $productCategory));

        $response->assertRedirect(route('productCategory.index'));

        $this->assertSoftDeleted($productCategory);
    }
}
