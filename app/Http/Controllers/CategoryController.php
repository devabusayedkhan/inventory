<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function LoadCategoryPage(Request $request)
    {
        return view("pages.dashbord.category-page");
    }

    public function GetCategory(Request $request)
    {
        try {
            $userId = $request->header("id");
            return Category::where("user_id", $userId)->get();
        } catch (\Throwable $th) {
            return "somthing was wrong!";
        }
    }

    public function AddCategory(Request $request)
    {
        try {
            $userId = $request->header("id");
            Category::create([
                "user_id" => $userId,
                "name" => $request->input("name"),
            ]);
            return response()->json([
                "status" => "success",
                "message" => "category create success"
            ]);
        } catch (\Throwable $th) {
            return "This category name already exists.";
        }
    }

    public function EditCategory(Request $request)
    {
        try {
            $userId = $request->header("id");
            $name = $request->input("name");
            $categoryId = $request->input("id");

            Category::where("id", $categoryId)
                ->where("user_id", $userId)
                ->update([
                    "name" => $name
                ]);

            return response()->json([
                "status" => "success",
                "message" => "Category Updated"
            ]);
        } catch (\Throwable $th) {
            return "This category name already exists.";
        }
    }

    public function DeleteCategory(Request $request)
    {
        $userId = $request->header("id");
        $categoryId = $request->input("id");

        try {
            Category::where("id", $categoryId)->where("user_id", $userId)->delete();

            return response()->json([
                "status" => "success",
                "message" => "Delete Category"
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
