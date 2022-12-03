<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PaymentMethodController
 */
class PaymentMethodControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $paymentMethods = PaymentMethod::factory()->count(3)->create();

        $response = $this->get(route('payment-method.index'));

        $response->assertOk();
        $response->assertViewIs('paymentMethod.index');
        $response->assertViewHas('paymentMethods');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('payment-method.create'));

        $response->assertOk();
        $response->assertViewIs('paymentMethod.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PaymentMethodController::class,
            'store',
            \App\Http\Requests\PaymentMethodStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $description = $this->faker->text;
        $status = $this->faker->boolean;

        $response = $this->post(route('payment-method.store'), [
            'description' => $description,
            'status' => $status,
        ]);

        $paymentMethods = PaymentMethod::query()
            ->where('description', $description)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $paymentMethods);
        $paymentMethod = $paymentMethods->first();

        $response->assertRedirect(route('paymentMethod.index'));
        $response->assertSessionHas('paymentMethod.id', $paymentMethod->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $response = $this->get(route('payment-method.show', $paymentMethod));

        $response->assertOk();
        $response->assertViewIs('paymentMethod.show');
        $response->assertViewHas('paymentMethod');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $response = $this->get(route('payment-method.edit', $paymentMethod));

        $response->assertOk();
        $response->assertViewIs('paymentMethod.edit');
        $response->assertViewHas('paymentMethod');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PaymentMethodController::class,
            'update',
            \App\Http\Requests\PaymentMethodUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $paymentMethod = PaymentMethod::factory()->create();
        $description = $this->faker->text;
        $status = $this->faker->boolean;

        $response = $this->put(route('payment-method.update', $paymentMethod), [
            'description' => $description,
            'status' => $status,
        ]);

        $paymentMethod->refresh();

        $response->assertRedirect(route('paymentMethod.index'));
        $response->assertSessionHas('paymentMethod.id', $paymentMethod->id);

        $this->assertEquals($description, $paymentMethod->description);
        $this->assertEquals($status, $paymentMethod->status);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $response = $this->delete(route('payment-method.destroy', $paymentMethod));

        $response->assertRedirect(route('paymentMethod.index'));

        $this->assertSoftDeleted($paymentMethod);
    }
}
