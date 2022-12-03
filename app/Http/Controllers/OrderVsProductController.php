<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderVsProductStoreRequest;
use App\Http\Requests\OrderVsProductUpdateRequest;
use App\Models\OrderVsProduct;
use Illuminate\Http\Request;

class OrderVsProductController extends Controller
{

    public function index(Request $request)
    {
        $orderVsProducts = OrderVsProduct::all();

        return view('orderVsProduct.index', compact('orderVsProducts'));
    }

    public function create(Request $request)
    {
        return view('orderVsProduct.create');
    }

    public function store(OrderVsProductStoreRequest $request)
    {
        $orderVsProduct = OrderVsProduct::create($request->validated());

        $request->session()->flash('orderVsProduct.id', $orderVsProduct->id);

        return redirect()->route('orderVsProduct.index');
    }

    public function show(Request $request, OrderVsProduct $orderVsProduct)
    {
        return view('orderVsProduct.show', compact('orderVsProduct'));
    }

    public function edit(Request $request, OrderVsProduct $orderVsProduct)
    {
        return view('orderVsProduct.edit', compact('orderVsProduct'));
    }

    public function update(OrderVsProductUpdateRequest $request, OrderVsProduct $orderVsProduct)
    {
        $orderVsProduct->update($request->validated());

        $request->session()->flash('orderVsProduct.id', $orderVsProduct->id);

        return redirect()->route('orderVsProduct.index');
    }

    public function destroy(Request $request, OrderVsProduct $orderVsProduct)
    {
        $orderVsProduct->delete();

        return redirect()->route('orderVsProduct.index');
    }

}
