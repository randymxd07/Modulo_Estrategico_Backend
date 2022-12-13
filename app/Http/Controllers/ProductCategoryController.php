<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryStoreRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{

    public function index(Request $request)
    {

        try {

            $productCategories = ProductCategory::all();

            if($request->query('number') != 0)
                $productCategories = ProductCategory::all()->take($request->query('number'));

            if($productCategories->count() == 0)
                return response()->json([
                    "data" => null,
                    "message" => "No hay categorias de productos en la base de datos"
                ], 404);

            return response()->json([
                "data" => $productCategories,
                "message" => "Categorias de productos encontradas correctamente"
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

    public function store(ProductCategoryStoreRequest $request)
    {

        try {

            DB::beginTransaction();

            $productCategory = ProductCategory::create($request->validated());

            if(!$productCategory)
                return response()->json([
                   "data" => null,
                   "message" => "No se pudo crear la categoria del producto"
                ], 400);

            DB::commit();

            return response()->json([
                "data" => $productCategory,
                "message" => "Categoria del producto creada correctamente"
            ], 201);

        } catch (Exception $e){

            DB::rollBack();

            throw new \Exception($e);

        }

    }

    public function show($id)
    {

        try {

            $productCategory = ProductCategory::findOrFail($id);

            if(!$productCategory)
                return response()->json([
                    "data" => null,
                    "message" => `La categoria de producto con el id: ${$id} no pudo ser encontrada`
                ], 404);

            return response()->json([
                "data" => $productCategory,
                "message" => "Categorias de productos encontrada correctamente"
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

    public function update($id, ProductCategoryUpdateRequest $request)
    {

        try {

            DB::beginTransaction();

            $data = [
                "name" => $request["name"],
                "description" => $request["description"],
                "status" => $request["status"],
            ];

            $productCategory = ProductCategory::where('id', '=', $id)->update($data);

            if(!$productCategory)
                return response()->json([
                    "data" => null,
                    "message" => "No se pude actualizar la categoria del producto"
                ], 400);

            DB::commit();

            return response()->json([
                "data" => $data,
                "message" => "Categoria del producto actualizada correctamente"
            ], 200);

        } catch (Exception $e){

            DB::rollBack();

            throw new \Exception($e);

        }

    }

    public function destroy($id)
    {

        try {

            $productCategory = ProductCategory::findOrFail($id);

            $productCategory->delete();

            return response()->json([
                "data" => $productCategory,
                "message" => 'La categoria de producto fue eliminada correctamente'
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

}
