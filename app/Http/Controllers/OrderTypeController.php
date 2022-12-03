<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderTypeStoreRequest;
use App\Http\Requests\OrderTypeUpdateRequest;
use App\Models\OrderType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderTypeController extends Controller
{

    public function index()
    {

        try {

            $orderTypes = OrderType::all();

            if($orderTypes->count() == 0)
                return response()->json([
                    "data" => null,
                    "message" => "No hay tipo de ordenes en la base de datos"
                ], 404);

            return response()->json([
                "data" => $orderTypes,
                "message" => "Tipos de ordenes encontrados correctamente"
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

    public function store(OrderTypeStoreRequest $request)
    {

        try {

            DB::beginTransaction();

            $orderType = OrderType::create($request->validated());

            if(!$orderType)
                return response()->json([
                    "data" => null,
                    "message" => "No se pudo crear el tipo de orden"
                ], 400);

            DB::commit();

            return response()->json([
                "data" => $orderType,
                "message" => "Tipo de orden creado correctamente"
            ], 201);

        } catch (\Exception $e){

            DB::rollBack();

            throw new \Exception($e);

        }

    }

    public function show($id)
    {

        try {

            $orderType = OrderType::findOrFail($id);

            if(!$orderType)
                return response()->json([
                    "data" => null,
                    "message" => `El tipo de orden con el id: ${$id} no pudo ser encontrado`
                ], 404);

            return response()->json([
                "data" => $orderType,
                "message" => "Tipo de orden encontrado correctamente"
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

    public function update($id, OrderTypeUpdateRequest $request)
    {

        try {

            DB::beginTransaction();

            $orderType = OrderType::where('id', '=', $id)->update($request->all());

            if(!$orderType)
                return response()->json([
                    "data" => null,
                    "message" => "No se pude actualizar el tipo de orden"
                ], 400);

            DB::commit();

            return response()->json([
                "data" => $request->all(),
                "message" => "Tipo de orden actualizado correctamente"
            ], 200);

        } catch (Exception $e){

            DB::rollBack();

            throw new \Exception($e);

        }

    }

    public function destroy($id)
    {

        try {

            $orderType = OrderType::findOrFail($id);

            $orderType->delete();

            return response()->json([
                "data" => $orderType,
                "message" => 'El tipo de orden fue eliminado correctamente'
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

}
