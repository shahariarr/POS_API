<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//auth web api routes(login,register,logout,profile,update profile)

Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/user-login',[UserController::class,'UserLogin']);
Route::get('/logout',[UserController::class,'UserLogout'])->middleware('auth:sanctum');
Route::get('/user-profile',[UserController::class,'UserProfile'])->middleware('auth:sanctum');
Route::post('/user-update',[UserController::class,'UpdateProfile'])->middleware('auth:sanctum');
Route::post('/send-otp',[UserController::class,'SendOTPCode']);
Route::post('/verify-otp',[UserController::class,'VerifyOTP']);
Route::post('/reset-password',[UserController::class,'ResetPassword'])->middleware('auth:sanctum');


//page routes
Route::get('/',[UserController::class,'UserLoginView'])->name('login');



//web api routes for category(category create,category list,category update,category delete,category by id,)

 Route::post("/create-category",[CategoryController::class,'CategoryCreate'])->middleware('auth:sanctum');
 Route::get("/list-category",[CategoryController::class,'CategoryList'])->middleware('auth:sanctum');
 Route::post("/delete-category",[CategoryController::class,'CategoryDelete'])->middleware('auth:sanctum');
 Route::post("/update-category",[CategoryController::class,'CategoryUpdate'])->middleware('auth:sanctum');
 Route::post("/category-by-id",[CategoryController::class,'CategoryByID'])->middleware('auth:sanctum');



 // Customer Web API Routes
Route::post("/create-customer",[CustomerController::class,'CustomerCreate'])->middleware('auth:sanctum');
Route::get("/list-customer",[CustomerController::class,'CustomerList'])->middleware('auth:sanctum');
Route::post("/delete-customer",[CustomerController::class,'CustomerDelete'])->middleware('auth:sanctum');
Route::post("/update-customer",[CustomerController::class,'CustomerUpdate'])->middleware('auth:sanctum');
Route::post("/customer-by-id",[CustomerController::class,'CustomerByID'])->middleware('auth:sanctum');


//product web api routes(product create,product list,product update,product delete,product by id,)

Route::post("/create-product",[ProductController::class,'ProductCreate'])->middleware('auth:sanctum');
Route::get("/list-product",[ProductController::class,'ProductList'])->middleware('auth:sanctum');
Route::post("/delete-product",[ProductController::class,'ProductDelete'])->middleware('auth:sanctum');
Route::post("/update-product",[ProductController::class,'ProductUpdate'])->middleware('auth:sanctum');
Route::post("/product-by-id",[ProductController::class,'ProductByID'])->middleware('auth:sanctum');




























// Route::view('/userRegistration','pages.auth.page-registration')->name('registration');
// Route::view('/sendOtp','pages.auth.send-otp-page');
// Route::view('/verifyOtp','pages.auth.verify-otp-page');
// Route::view('/resetPassword','pages.auth.reset-pass-page');
// Route::view('/userProfile','pages.dashboard.profile-page');



//dashboard page routes
//Route::view('/dashboard','pages.dashboard.page-dashboard')->name('dashboard')->middleware('auth:sanctum');
