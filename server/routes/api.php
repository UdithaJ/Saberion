<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/register', [UserController::class,'register']);
Route::post('/login', [UserController::class,'login']);
Route::post('/add_product', [\App\Http\Controllers\ProductController::class,'add']);
Route::put('/update_product/{id}', [\App\Http\Controllers\ProductController::class,'update']);
Route::delete('/delete_product/{id}', [\App\Http\Controllers\ProductController::class,'delete']);
Route::get('/get_product/{id}', [\App\Http\Controllers\ProductController::class,'getProduct']);
Route::get('/get_all_product/{inventory_id}', [\App\Http\Controllers\ProductController::class,'getAllProduct']);
Route::middleware('auth:sanctum')->get('/user', [UserController::class,'getUser']);
Route::get('/branches', [\App\Http\Controllers\BranchController::class,'getAllBranches']);
