<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodStoreRequest;
use App\Http\Requests\PaymentMethodUpdateRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends Controller
{

    public function index()
    {

        try {

            $paymentMethods = PaymentMethod::all();

            if($paymentMethods->count() == 0)
                return response()->json([
                    "data" => null,
                    "message" => "No hay metodos de pago en la base de datos"
                ], 404);

            return response()->json([
                "data" => $paymentMethods,
                "message" => "Metodos de pagos encontrados correctamente"
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

    public function store(PaymentMethodStoreRequest $request)
    {

        try {

            DB::beginTransaction();

            $paymentMethod = PaymentMethod::create($request->validated());

            if(!$paymentMethod)
                return response()->json([
                    "data" => null,
                    "message" => "No se pudo crear el metodo de pago"
                ], 400);

            DB::commit();

            return response()->json([
                "data" => $paymentMethod,
                "message" => "Metodo de pago creado correctamente"
            ], 201);

        } catch (\Exception $e){

            DB::rollBack();

            throw new \Exception($e);

        }

    }

    public function show($id)
    {

        try {

            $paymentMethod = PaymentMethod::findOrFail($id);

            if(!$paymentMethod)
                return response()->json([
                    "data" => null,
                    "message" => `El metodo de pago con el id: ${$id} no pudo ser encontrado`
                ], 404);

            return response()->json([
                "data" => $paymentMethod,
                "message" => "Metodo de pago encontrado correctamente"
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

    public function update($id, PaymentMethodUpdateRequest $request)
    {

        try {

            DB::beginTransaction();

            $paymentMethod = PaymentMethod::where('id', '=', $id)->update($request->all());

            if(!$paymentMethod)
                return response()->json([
                    "data" => null,
                    "message" => "No se pude actualizar el metodo de pago"
                ], 400);

            DB::commit();

            return response()->json([
                "data" => $request->all(),
                "message" => "Metodo de pago actualizado correctamente"
            ], 200);

        } catch (Exception $e){

            DB::rollBack();

            throw new \Exception($e);

        }

    }

    public function destroy($id)
    {

        try {

            $paymentMethod = PaymentMethod::findOrFail($id);

            $paymentMethod->delete();

            return response()->json([
                "data" => $paymentMethod,
                "message" => 'El metodo de pago fue eliminado correctamente'
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

}
