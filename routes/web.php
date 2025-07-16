<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashbordController;
use App\Http\Controllers\ForgetPassword;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserContorller;
use App\Http\Middleware\VerifyUserLogin;
use Illuminate\Support\Facades\Route;

// Page Route
Route::fallback([AppController::class, 'NotFount404']);
Route::get('/', [AppController::class, 'appLoader']);

Route::get('/loginRegister', [UserContorller::class, 'loginRegisterLoad']);
// Dashbord load
Route::get('/dashboard', [DashbordController::class, 'DashbordLoader'])
->middleware([VerifyUserLogin::class]);
Route::get('/userprofile', [UserContorller::class,'Profile'])
->middleware([VerifyUserLogin::class]);
// category page
Route::get('/category', [CategoryController::class, "LoadCategoryPage"])
->middleware([VerifyUserLogin::class]);
// Customer page
Route::get('/customer', [CustomerController::class, "LoadCustomerPage"])
->middleware([VerifyUserLogin::class]);
// Customer page
Route::get('/product', [ProductController::class, "LoadProductPage"])
->middleware([VerifyUserLogin::class]);
Route::get('/sale', [InvoiceController::class,'salePageLoad'])
->middleware([VerifyUserLogin::class]);
Route::get('/invoice', [InvoiceController::class,'invoicePageLoad'])
->middleware([VerifyUserLogin::class]);
Route::get('/report', [ReportController::class,'ReportPage'])
->middleware([VerifyUserLogin::class]);

// forget password
Route::get('/sendotpform', [ForgetPassword::class, 'SendOtpForm']);
Route::get('/verifyotpform', [ForgetPassword::class, 'VerifyOtp']);
Route::get('/updatepasswordgform', [ForgetPassword::class, 'UpdatePassword']);

