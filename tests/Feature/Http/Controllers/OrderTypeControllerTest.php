<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\OrderType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrderTypeController
 */
class OrderTypeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $orderTypes = OrderType::factory()->count(3)->create();

        $response = $this->get(route('order-type.index'));

        $response->assertOk();
        $response->assertViewIs('orderType.index');
        $response->assertViewHas('orderTypes');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('order-type.create'));

        $response->assertOk();
        $response->assertViewIs('orderType.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrderTypeController::class,
            'store',
            \App\Http\Requests\OrderTypeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $description = $this->faker->text;
        $status = $this->faker->boolean;

        $response = $this->post(route('order-type.store'), [
            'description' => $description,
            'status' => $status,
        ]);

        $orderTypes = OrderType::query()
            ->where('description', $description)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $orderTypes);
        $orderType = $orderTypes->first();

        $response->assertRedirect(route('orderType.index'));
        $response->assertSessionHas('orderType.id', $orderType->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $orderType = OrderType::factory()->create();

        $response = $this->get(route('order-type.show', $orderType));

        $response->assertOk();
        $response->assertViewIs('orderType.show');
        $response->assertViewHas('orderType');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $orderType = OrderType::factory()->create();

        $response = $this->get(route('order-type.edit', $orderType));

        $response->assertOk();
        $response->assertViewIs('orderType.edit');
        $response->assertViewHas('orderType');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrderTypeController::class,
            'update',
            \App\Http\Requests\OrderTypeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $orderType = OrderType::factory()->create();
        $description = $this->faker->text;
        $status = $this->faker->boolean;

        $response = $this->put(route('order-type.update', $orderType), [
            'description' => $description,
            'status' => $status,
        ]);

        $orderType->refresh();

        $response->assertRedirect(route('orderType.index'));
        $response->assertSessionHas('orderType.id', $orderType->id);

        $this->assertEquals($description, $orderType->description);
        $this->assertEquals($status, $orderType->status);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $orderType = OrderType::factory()->create();

        $response = $this->delete(route('order-type.destroy', $orderType));

        $response->assertRedirect(route('orderType.index'));

        $this->assertSoftDeleted($orderType);
    }
}
