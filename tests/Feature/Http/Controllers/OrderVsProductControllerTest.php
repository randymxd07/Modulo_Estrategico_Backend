<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Order;
use App\Models\OrderVsProduct;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrderVsProductController
 */
class OrderVsProductControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $orderVsProducts = OrderVsProduct::factory()->count(3)->create();

        $response = $this->get(route('order-vs-product.index'));

        $response->assertOk();
        $response->assertViewIs('orderVsProduct.index');
        $response->assertViewHas('orderVsProducts');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('order-vs-product.create'));

        $response->assertOk();
        $response->assertViewIs('orderVsProduct.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrderVsProductController::class,
            'store',
            \App\Http\Requests\OrderVsProductStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $order = Order::factory()->create();
        $product = Product::factory()->create();
        $quantity = $this->faker->numberBetween(-10000, 10000);

        $response = $this->post(route('order-vs-product.store'), [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);

        $orderVsProducts = OrderVsProduct::query()
            ->where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->where('quantity', $quantity)
            ->get();
        $this->assertCount(1, $orderVsProducts);
        $orderVsProduct = $orderVsProducts->first();

        $response->assertRedirect(route('orderVsProduct.index'));
        $response->assertSessionHas('orderVsProduct.id', $orderVsProduct->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $orderVsProduct = OrderVsProduct::factory()->create();

        $response = $this->get(route('order-vs-product.show', $orderVsProduct));

        $response->assertOk();
        $response->assertViewIs('orderVsProduct.show');
        $response->assertViewHas('orderVsProduct');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $orderVsProduct = OrderVsProduct::factory()->create();

        $response = $this->get(route('order-vs-product.edit', $orderVsProduct));

        $response->assertOk();
        $response->assertViewIs('orderVsProduct.edit');
        $response->assertViewHas('orderVsProduct');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrderVsProductController::class,
            'update',
            \App\Http\Requests\OrderVsProductUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $orderVsProduct = OrderVsProduct::factory()->create();
        $order = Order::factory()->create();
        $product = Product::factory()->create();
        $quantity = $this->faker->numberBetween(-10000, 10000);

        $response = $this->put(route('order-vs-product.update', $orderVsProduct), [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);

        $orderVsProduct->refresh();

        $response->assertRedirect(route('orderVsProduct.index'));
        $response->assertSessionHas('orderVsProduct.id', $orderVsProduct->id);

        $this->assertEquals($order->id, $orderVsProduct->order_id);
        $this->assertEquals($product->id, $orderVsProduct->product_id);
        $this->assertEquals($quantity, $orderVsProduct->quantity);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $orderVsProduct = OrderVsProduct::factory()->create();

        $response = $this->delete(route('order-vs-product.destroy', $orderVsProduct));

        $response->assertRedirect(route('orderVsProduct.index'));

        $this->assertSoftDeleted($orderVsProduct);
    }
}
