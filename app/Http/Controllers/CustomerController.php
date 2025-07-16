<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function LoadCustomerPage(Request $request)
    {
        return view("pages.dashbord.customer-page");
    }

    // get customer data
    public function GetCustomer(Request $request)
    {
        try {
            $userId = $request->header("id");
            return Customer::where("user_id", $userId)->get();
        } catch (\Throwable $th) {
            return "somthing was wrong!";
        }
    }

    // Add a new customer
    public function AddCustomer(Request $request)
    {
        try {
            $userId = $request->header("id");
            Customer::create([
                "name" => $request->input("name"),
                "email" => $request->input("email"),
                "mobile" => $request->input("mobile"),
                "user_id" => $userId,
            ]);
            return response()->json([
                "status" => "success",
                "message" => "Customer create success"
            ]);
        } catch (\Throwable $th) {
            return "This Customer already exists.";
        }
    }

    // update customer data
        public function EditCustomer(Request $request)
    {
        try {
            $userId = $request->header("id");
            $name = $request->input("name");
            $email = $request->input("email");
            $mobile = $request->input("mobile");
            $customerId = $request->input("id");

            Customer::where("id", $customerId)
                ->where("user_id", $userId)
                ->update([
                    "name" => $name,
                    "email" => $email,
                    "mobile"=> $mobile
                ]);

            return response()->json([
                "status" => "success",
                "message" => "Customer Updated"
            ]);
        } catch (\Throwable $th) {
            return "This Customer already exists.";
        }
    }

    // delete customer data
        public function DeleteCustomer(Request $request)
    {
        $userId = $request->header("id");
        $customerId = $request->input("id");

        try {
            Customer::where("id", $customerId)->where("user_id", $userId)->delete();

            return response()->json([
                "status" => "success",
                "message" => "Delete Customer"
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // Search customer
    public function FindCustomer(Request $request){
        $userId = $request->header("id");
        $customerId = $request->input("id");
        try {
            return Customer::where("id", $customerId)->where("user_id", $userId)->first();
        } catch (\Throwable $th) {
            return "Customer not found";
        }
    }
}
