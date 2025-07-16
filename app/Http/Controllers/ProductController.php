<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function LoadProductPage(Request $request)
    {
        return view("pages.dashbord.product-page");
    }
    // get product
    public function GetProduct(Request $request)
    {
        try {
            $userId = $request->header("id");
            return Product::where('user_id', $userId)->get();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // add product
    public function AddProduct(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 'failed',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        try {
            $userId = $request->header("id");
            $categoryId = $request->input("category_id");
            $name = $request->input("name");
            $price = $request->input("price");
            $unit = $request->input("unit");
            $img = $request->file("img");

            // file name and extention config
            $fileExtention = $img->getClientOriginalExtension();
            $imgName = uniqid() . '_' . $userId . '_' . time() . '.' . $fileExtention;
            $imgUrl = "productimg/$imgName";
            // upload image
            $img->move(public_path("productimg"), $imgName);

            // Save to Database
            Product::create([
                'user_id' => $userId,
                'category_id' => $categoryId,
                'name' => $name,
                'price' => $price,
                'unit' => $unit,
                'img' => $imgUrl,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'product success created'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'All field are required'
            ]);
        }
    }

    // Edite product
    public function EditProduct(Request $request)
    {
        try {
            $userId = $request->header('id');
            $productId = $request->input('id');

            $categoryId = $request->input('category_id');
            $name = $request->input('name');
            $price = $request->input('price');
            $unit = $request->input('unit');

            if ($request->hasFile('img')) {

                // Upload new file
                $img = $request->file('img');
                $fileExtention = $img->getClientOriginalExtension();
                $imgName = uniqid() . '_' . $userId . '_' . time() . '.' . $fileExtention;
                $imgUrl = 'productimg/' . $imgName;
                $img->move(public_path('productimg'), $imgName);

                // Delete old file
                $oldFilePath = $request->input('old_img');
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }

                // Update product from database
                Product::where('id', $productId)->where('user_id', $userId)->update([
                    'name' => $name,
                    'price' => $price,
                    'unit' => $unit,
                    'img' => $imgUrl,
                    'category_id' => $categoryId
                ]);
            } else {
                Product::where('id', $productId)->where('user_id', $userId)->update([
                    'name' => $name,
                    'price' => $price,
                    'unit' => $unit,
                    'category_id' => $categoryId
                ]);
            }

            return response()->json([
                "status" => "success",
                "message" => "Product Updated"
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    // delete product
    public function DeleteProduct(Request $request)
    {
        try {
            $userId = $request->header('id');
            $productId = $request->input('id');
            $oldFilePath = $request->input('old_img');
            // delete image
            File::delete($oldFilePath);

            Product::where('user_id', $userId)->where('id', $productId)->delete();

            return response()->json([
                "status" => "success",
                "message" => "Delete Product"
            ]);
        } catch (\Throwable $th) {
            return "not Delete";
        }
    }

    public function getProductByID(Request $request){
        try {
            $userId = $request->header('id');
            $productId = $request->input('id');

            return Product::where('user_id', $userId)->where('id', $productId)->first();
            
        } catch (\Throwable $th) {
            return "Unsuccess";
        }
    }
}
