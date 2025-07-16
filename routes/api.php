<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashbordController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserContorller;
use App\Http\Middleware\PasswordTokenVerification;
use App\Http\Middleware\VerifyUserLogin;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserContorller::class, 'register']);
// login
Route::post('/userLogin', [UserContorller::class, 'login']);
Route::post('/sendotp', [UserContorller::class, 'SendOTPCode']);
// logout 
Route::get('/logout', [UserContorller::class, 'Logout']);
// verify otp
Route::post('/verifyotp', [UserContorller::class, 'VerifyOTP']);
// Update password
Route::post('/updatepassword', [UserContorller::class, 'UpdatePassword'])
        ->middleware([PasswordTokenVerification::class]);
// get user profile data
Route::get('/getuserdata', [UserContorller::class, 'GetUserData'])
->middleware([VerifyUserLogin::class]);
// update user profile data
Route::post('/updateuserdata', [UserContorller::class, 'UpdateUserData'])
->middleware([VerifyUserLogin::class]);
// category ------------------------------------------------------------------------------------
Route::get('/getcategory', [CategoryController::class,'GetCategory'])
->middleware([VerifyUserLogin::class]);
// add category
Route::post('/addcategory', [CategoryController::class,'AddCategory'])
->middleware([VerifyUserLogin::class]);
// update category
Route::post('/updatecategory', [CategoryController::class,'EditCategory'])
->middleware([VerifyUserLogin::class]);
// Delete category
Route::post('/deletecategory', [CategoryController::class,'DeleteCategory'])
->middleware([VerifyUserLogin::class]);
//End category-----------------------------------------------------------------------------------

//  Customer -----------------------------------
Route::get('/getcustomer', [CustomerController::class,'GetCustomer'])
->middleware([VerifyUserLogin::class]);
// add customer
Route::post('/addcustomer', [CustomerController::class,'AddCustomer'])
->middleware([VerifyUserLogin::class]);
// update customer
Route::post('/updatecustomer', [CustomerController::class,'EditCustomer'])
->middleware([VerifyUserLogin::class]);
// Delete customer
Route::post('/deletecustomer', [CustomerController::class,'DeleteCustomer'])
->middleware([VerifyUserLogin::class]);
// search customer
Route::post('/findcustomer', [CustomerController::class,'FindCustomer'])
->middleware([VerifyUserLogin::class]);
// End Customer --------------------------------

//  product -----------------------------------
Route::get('/getproduct', [ProductController::class,'GetProduct'])
->middleware([VerifyUserLogin::class]);
// add product
Route::post('/addproduct', [ProductController::class,'AddProduct'])
->middleware([VerifyUserLogin::class]);
// update product
Route::post('/updateproduct', [ProductController::class,'EditProduct'])
->middleware([VerifyUserLogin::class]);
// Delete product
Route::post('/deleteproduct', [ProductController::class,'DeleteProduct'])
->middleware([VerifyUserLogin::class]);

Route::post('/productfiend', [ProductController::class,'getProductByID'])
->middleware([VerifyUserLogin::class]);
// End product --------------------------------

// Invoice -------------------------------------
Route::post('/invoicecreate', [InvoiceController::class,'invoiceCreate'])
->middleware([VerifyUserLogin::class]);

Route::get('/invoiceselect', [InvoiceController::class,'invoiceSelect'])
->middleware([VerifyUserLogin::class]);

Route::post('/invoicedetails', [InvoiceController::class,'invoiceDetails'])
->middleware([VerifyUserLogin::class]);

Route::post('/invoicedelete', [InvoiceController::class,'invoiceDelete'])
->middleware([VerifyUserLogin::class]);
// get all Summery
Route::get('/summery', [DashbordController::class,'Summery'])
->middleware([VerifyUserLogin::class]);
// End Invoice ---------------------------------

// Report
Route::get("/sales-report/{fromdate}/{todate}", [ReportController::class,"SalesReport"])
        ->middleware([VerifyUserLogin::class]);