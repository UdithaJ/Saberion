<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{


    public function add(Request $request): JsonResponse{

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'brand' => 'required',
            'features' => 'required',
            'price' => 'required',
            'inventory_id' => 'required',
            'quantity' => 'required',
            'availability' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $product = Product::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'features' => $request->features,
            'price' => $request->price,
            'inventoryId' => $request->inventory_id,
            'quantity' => $request->quantity,
            'availability' => $request->availability,
        ]);

        $product->save();
        return response()->json(["product" => $product]);
    }

    public function update(Request $request, int $id): JsonResponse{

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'brand' => 'required',
            'features' => 'required',
            'price' => 'required',
            'inventory_id' => 'required',
            'quantity' => 'required',
            'availability' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $product = Product::find($id);

        $product->name = $request->get('name');
        $product->brand = $request->get('brand');
        $product->features = $request->get('features');
        $product->price = $request->get('price');
        $product->inventoryId = $request->get('inventory_id');
        $product->quantity = $request->get('quantity');
        $product->availability = $request->get('availability');

        $product->save();
        return response()->json(["product" => $product]);
    }

    public function delete($id): JsonResponse
    {
        $product = Product::findOrFail($id);
        if ($product->delete()) {
            return response()->json([
                "success" => true,
                "message" => "Product deleted successfully.",
                "data" => $product->id
            ]);
        }
        else{
            return response()->json(["message" => "Failed"]);
        }
    }

    public function getProduct(Request $request, int $id): JsonResponse{

        $product = Product::find($id);
        return response()->json(["product" => $product]);
    }

    public function getAllProduct(Request $request, int $inventoryId): JsonResponse{

        $products = Product::where('inventoryId', $inventoryId)->orderBy('created_at', 'desc')->get();
        return response()->json(["product" => $products]);
    }
}
