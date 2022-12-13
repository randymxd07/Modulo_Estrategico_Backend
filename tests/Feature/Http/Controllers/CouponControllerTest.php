<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Coupon;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CouponController
 */
class CouponControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $coupons = Coupon::factory()->count(3)->create();

        $response = $this->get(route('coupon.index'));

        $response->assertOk();
        $response->assertViewIs('coupon.index');
        $response->assertViewHas('coupons');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('coupon.create'));

        $response->assertOk();
        $response->assertViewIs('coupon.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CouponController::class,
            'store',
            \App\Http\Requests\CouponStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $description = $this->faker->text;
        $porcent = $this->faker->randomFloat(/** decimal_attributes **/);
        $product_category = ProductCategory::factory()->create();
        $status = $this->faker->boolean;

        $response = $this->post(route('coupon.store'), [
            'description' => $description,
            'porcent' => $porcent,
            'product_category_id' => $product_category->id,
            'status' => $status,
        ]);

        $coupons = Coupon::query()
            ->where('description', $description)
            ->where('porcent', $porcent)
            ->where('product_category_id', $product_category->id)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $coupons);
        $coupon = $coupons->first();

        $response->assertRedirect(route('coupon.index'));
        $response->assertSessionHas('coupon.id', $coupon->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $coupon = Coupon::factory()->create();

        $response = $this->get(route('coupon.show', $coupon));

        $response->assertOk();
        $response->assertViewIs('coupon.show');
        $response->assertViewHas('coupon');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $coupon = Coupon::factory()->create();

        $response = $this->get(route('coupon.edit', $coupon));

        $response->assertOk();
        $response->assertViewIs('coupon.edit');
        $response->assertViewHas('coupon');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CouponController::class,
            'update',
            \App\Http\Requests\CouponUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $coupon = Coupon::factory()->create();
        $description = $this->faker->text;
        $porcent = $this->faker->randomFloat(/** decimal_attributes **/);
        $product_category = ProductCategory::factory()->create();
        $status = $this->faker->boolean;

        $response = $this->put(route('coupon.update', $coupon), [
            'description' => $description,
            'porcent' => $porcent,
            'product_category_id' => $product_category->id,
            'status' => $status,
        ]);

        $coupon->refresh();

        $response->assertRedirect(route('coupon.index'));
        $response->assertSessionHas('coupon.id', $coupon->id);

        $this->assertEquals($description, $coupon->description);
        $this->assertEquals($porcent, $coupon->porcent);
        $this->assertEquals($product_category->id, $coupon->product_category_id);
        $this->assertEquals($status, $coupon->status);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $coupon = Coupon::factory()->create();

        $response = $this->delete(route('coupon.destroy', $coupon));

        $response->assertRedirect(route('coupon.index'));

        $this->assertSoftDeleted($coupon);
    }
}
