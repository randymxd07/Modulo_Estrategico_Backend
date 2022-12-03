<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Order;
use App\Models\OrderType;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrderController
 */
class OrderControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $orders = Order::factory()->count(3)->create();

        $response = $this->get(route('order.index'));

        $response->assertOk();
        $response->assertViewIs('order.index');
        $response->assertViewHas('orders');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('order.create'));

        $response->assertOk();
        $response->assertViewIs('order.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrderController::class,
            'store',
            \App\Http\Requests\OrderStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $user = User::factory()->create();
        $order_type = OrderType::factory()->create();
        $payment_method = PaymentMethod::factory()->create();
        $latitude = $this->faker->latitude;
        $longitude = $this->faker->longitude;
        $status = $this->faker->boolean;

        $response = $this->post(route('order.store'), [
            'user_id' => $user->id,
            'order_type_id' => $order_type->id,
            'payment_method_id' => $payment_method->id,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'status' => $status,
        ]);

        $orders = Order::query()
            ->where('user_id', $user->id)
            ->where('order_type_id', $order_type->id)
            ->where('payment_method_id', $payment_method->id)
            ->where('latitude', $latitude)
            ->where('longitude', $longitude)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $orders);
        $order = $orders->first();

        $response->assertRedirect(route('order.index'));
        $response->assertSessionHas('order.id', $order->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $order = Order::factory()->create();

        $response = $this->get(route('order.show', $order));

        $response->assertOk();
        $response->assertViewIs('order.show');
        $response->assertViewHas('order');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $order = Order::factory()->create();

        $response = $this->get(route('order.edit', $order));

        $response->assertOk();
        $response->assertViewIs('order.edit');
        $response->assertViewHas('order');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrderController::class,
            'update',
            \App\Http\Requests\OrderUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $order = Order::factory()->create();
        $user = User::factory()->create();
        $order_type = OrderType::factory()->create();
        $payment_method = PaymentMethod::factory()->create();
        $latitude = $this->faker->latitude;
        $longitude = $this->faker->longitude;
        $status = $this->faker->boolean;

        $response = $this->put(route('order.update', $order), [
            'user_id' => $user->id,
            'order_type_id' => $order_type->id,
            'payment_method_id' => $payment_method->id,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'status' => $status,
        ]);

        $order->refresh();

        $response->assertRedirect(route('order.index'));
        $response->assertSessionHas('order.id', $order->id);

        $this->assertEquals($user->id, $order->user_id);
        $this->assertEquals($order_type->id, $order->order_type_id);
        $this->assertEquals($payment_method->id, $order->payment_method_id);
        $this->assertEquals($latitude, $order->latitude);
        $this->assertEquals($longitude, $order->longitude);
        $this->assertEquals($status, $order->status);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $order = Order::factory()->create();

        $response = $this->delete(route('order.destroy', $order));

        $response->assertRedirect(route('order.index'));

        $this->assertSoftDeleted($order);
    }
}
