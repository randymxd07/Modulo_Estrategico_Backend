<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderVsProductStoreRequest;
use App\Http\Requests\OrderVsProductUpdateRequest;
use App\Models\OrderVsProduct;
use Illuminate\Http\Request;

class OrderVsProductController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderVsProducts = OrderVsProduct::all();

        return view('orderVsProduct.index', compact('orderVsProducts'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('orderVsProduct.create');
    }

    /**
     * @param \App\Http\Requests\OrderVsProductStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderVsProductStoreRequest $request)
    {
        $orderVsProduct = OrderVsProduct::create($request->validated());

        $request->session()->flash('orderVsProduct.id', $orderVsProduct->id);

        return redirect()->route('orderVsProduct.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OrderVsProduct $orderVsProduct
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, OrderVsProduct $orderVsProduct)
    {
        return view('orderVsProduct.show', compact('orderVsProduct'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OrderVsProduct $orderVsProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, OrderVsProduct $orderVsProduct)
    {
        return view('orderVsProduct.edit', compact('orderVsProduct'));
    }

    /**
     * @param \App\Http\Requests\OrderVsProductUpdateRequest $request
     * @param \App\Models\OrderVsProduct $orderVsProduct
     * @return \Illuminate\Http\Response
     */
    public function update(OrderVsProductUpdateRequest $request, OrderVsProduct $orderVsProduct)
    {
        $orderVsProduct->update($request->validated());

        $request->session()->flash('orderVsProduct.id', $orderVsProduct->id);

        return redirect()->route('orderVsProduct.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OrderVsProduct $orderVsProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, OrderVsProduct $orderVsProduct)
    {
        $orderVsProduct->delete();

        return redirect()->route('orderVsProduct.index');
    }
}
