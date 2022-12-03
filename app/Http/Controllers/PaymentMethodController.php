<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodStoreRequest;
use App\Http\Requests\PaymentMethodUpdateRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paymentMethods = PaymentMethod::all();

        return view('paymentMethod.index', compact('paymentMethods'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('paymentMethod.create');
    }

    /**
     * @param \App\Http\Requests\PaymentMethodStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentMethodStoreRequest $request)
    {
        $paymentMethod = PaymentMethod::create($request->validated());

        $request->session()->flash('paymentMethod.id', $paymentMethod->id);

        return redirect()->route('paymentMethod.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentMethod $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PaymentMethod $paymentMethod)
    {
        return view('paymentMethod.show', compact('paymentMethod'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentMethod $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PaymentMethod $paymentMethod)
    {
        return view('paymentMethod.edit', compact('paymentMethod'));
    }

    /**
     * @param \App\Http\Requests\PaymentMethodUpdateRequest $request
     * @param \App\Models\PaymentMethod $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentMethodUpdateRequest $request, PaymentMethod $paymentMethod)
    {
        $paymentMethod->update($request->validated());

        $request->session()->flash('paymentMethod.id', $paymentMethod->id);

        return redirect()->route('paymentMethod.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentMethod $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return redirect()->route('paymentMethod.index');
    }
}
