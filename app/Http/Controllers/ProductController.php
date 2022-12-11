<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\UpdateProductScoreRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use MongoDB\Driver\Exception\Exception;

class ProductController extends Controller
{

    public function recomendedProducts(){

//        $numberProductsByCategories = DB::table('order_vs_products')
//            ->join('products', 'products.id', '=', 'order_vs_products.product_id')
//            ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
//            ->select(
//                'order_vs_products.id as order_id',
//                'order_vs_products.product_id',
//                'products.name as product_name',
//                'product_categories.name as product_category_name'
//            )
//            ->get();

        $numberProductsByCategories = DB::table('order_vs_products')
            ->join('products', 'products.id', '=', 'order_vs_products.product_id')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->select(DB::raw('product_categories.id as product_category_id, product_categories.name, count(product_categories.name) as quantity'))
            ->orderBy('quantity', 'desc')
            ->groupBy('product_categories.name', 'product_categories.id')
            ->take(4)
            ->get();

        $products = [];

        foreach ($numberProductsByCategories as $numberProductsByCategory){

            $item = DB::table('products')
                ->where('products.product_category_id', '=', $numberProductsByCategory->product_category_id)
                ->inRandomOrder()
                ->take(2)
                ->get();

            array_push($products, $item);

        }

        return $products;

    }

    public function index()
    {
        try {

            $products = Product::inRandomOrder()->get();
//            $products = Product::all();

            if($products->count() == 0)
                return response()->json([
                    "data" => null,
                    "message" => "No hay productos en la base de datos"
                ], 404);

            return response()->json([
                "data" => $products,
                "mesagge" => "Productos encontrados correctamente"
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

    public function store(ProductStoreRequest $request)
    {

        try {

            DB::beginTransaction();

            $url = "";
            $image = $request->image_url;

            if($image){
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = Str::uuid().'.'.'png';
                \File::put(public_path(). '/public/productImages/' . $imageName, base64_decode($image));
                $url = URL::to('/') . '/public/productImages/' . $imageName;
            }

            $data = [
                "name" => $request['name'],
                "description" => $request['description'],
                "product_category_id" => $request['product_category_id'],
                "price" => $request['price'],
                "image_url" => $url,
                "estimated_time" => $request['estimated_time'],
                "score" => $request['score'],
                "status" => $request['status'],
            ];

            $product = Product::create($data);

            if(!$product)
                return response()->json([
                    "data" => null,
                    "message" => "No se pude crear el producto"
                ], 400);

            DB::commit();

            return response()->json([
                "data" => $data,
                "message" => "Producto creado correctamente"
            ], 201);

        } catch (Exception $e){

            DB::rollBack();

            throw new \Exception($e);

        }

    }

    public function show($id)
    {

        try {

            $product = Product::findOrFail($id);

            if(!$product)
                return response()->json([
                    "data" => null,
                    "message" => `El producto con el id: ${$id} no pudo ser encontrado`
                ], 404);

            return response()->json([
                "data" => $product,
                "mesagge" => "Producto encontrado correctamente"
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

    public function byCategory($id){

        try {

            $products = Product::where('product_category_id', '=', $id)->get();

            if($products->count() == 0)
                return response()->json([
                    "data" => null,
                    "message" => "No hay productos con esta categoria en la base de datos"
                ], 404);

            return response()->json([
                "data" => $products,
                "mesagge" => "Productos encontrados correctamente"
            ], 200);

        } catch (Exception $e){

            throw new \Exception($e);

        }

    }

    public function update($id, ProductUpdateRequest $request)
    {

        try {

            DB::beginTransaction();

            $url = "";
            $image = $request->image_url;

            if($image){
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = Str::uuid().'.'.'png';
                \File::put(public_path(). '/public/productImages/' . $imageName, base64_decode($image));
                $url = URL::to('/') . '/public/productImages/' . $imageName;
            }

            $data = [
                "name" => $request['name'],
                "description" => $request['description'],
                "product_category_id" => $request['product_category_id'],
                "price" => $request['price'],
                "image_url" => $url,
                "estimated_time" => $request['estimated_time'],
                "score" => $request['score'],
                "status" => $request['status'],
            ];

            $product = Product::where('id', '=', $id)->update($data);

            if(!$product)
                return response()->json([
                    "data" => null,
                    "message" => "No se pude actualizar el producto"
                ], 400);

            DB::commit();

            return response()->json([
                "data" => $data,
                "message" => "Producto actualizado correctamente"
            ], 200);

        } catch (Exception $e){

            DB::rollBack();

            throw new \Exception($e);

        }

    }

    public function putScore($id, UpdateProductScoreRequest $request){

        try {

            DB::beginTransaction();

            $product = Product::where('id', '=', $id)->update([
                "score" => $request['score']
            ]);

            if(!$product)
                return response()->json([
                    "data" => null,
                    "message" => "No se pude actualizar el score producto"
                ], 400);

            DB::commit();

            $pro = Product::where('id', '=', $id)->first();

            return response()->json([
                "data" => $pro,
                "message" => "Score del producto actualizado correctamente"
            ], 200);

        } catch(\Exception $e){

            DB::rollBack();

            throw new \Exception($e);

        }


    }

    public function destroy($id)
    {

        try {

            $product = Product::findOrFail($id);

            $product->delete();

            return response()->json([
                "data" => $product,
                "message" => 'El producto fue eliminado correctamente'
            ], 200);

        } catch (\Exception $e){

            throw new \Exception($e);

        }

    }

}
