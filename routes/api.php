<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Registercontroller;
use App\Http\Controllers\Api\ProductController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/test',function(){
    return response()->json('working',200);
});
Route::post('/register',[Registercontroller::class,'register']);
Route::post('/login',[Registercontroller::class,'login']);

Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::resource('/products',ProductController::class);
    Route::get('/logout',[Registercontroller::class,'logout']);
});
