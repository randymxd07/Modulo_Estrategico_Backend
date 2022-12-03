<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderTypeStoreRequest;
use App\Http\Requests\OrderTypeUpdateRequest;
use App\Models\OrderType;
use Illuminate\Http\Request;

class OrderTypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderTypes = OrderType::all();

        return view('orderType.index', compact('orderTypes'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('orderType.create');
    }

    /**
     * @param \App\Http\Requests\OrderTypeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderTypeStoreRequest $request)
    {
        $orderType = OrderType::create($request->validated());

        $request->session()->flash('orderType.id', $orderType->id);

        return redirect()->route('orderType.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OrderType $orderType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, OrderType $orderType)
    {
        return view('orderType.show', compact('orderType'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OrderType $orderType
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, OrderType $orderType)
    {
        return view('orderType.edit', compact('orderType'));
    }

    /**
     * @param \App\Http\Requests\OrderTypeUpdateRequest $request
     * @param \App\Models\OrderType $orderType
     * @return \Illuminate\Http\Response
     */
    public function update(OrderTypeUpdateRequest $request, OrderType $orderType)
    {
        $orderType->update($request->validated());

        $request->session()->flash('orderType.id', $orderType->id);

        return redirect()->route('orderType.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OrderType $orderType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, OrderType $orderType)
    {
        $orderType->delete();

        return redirect()->route('orderType.index');
    }
}
