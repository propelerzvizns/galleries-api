<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GalleriesController;
use App\Http\Controllers\AuthorController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//AUTH ROUTES
Route::post('/login', [ AuthController::class, 'login']);
Route::post('/is-logged', [ AuthController::class, 'isLogged']);
Route::post('/logout', [ AuthController::class, 'logout']);
Route::post('/register', [ AuthController::class, 'register']);
Route::post('/refresh', [ AuthController::class, 'refresh']);
//GALLERIES ROUTES
Route::get('/galleries', [GalleriesController::class, 'index']);
Route::get('/galleries/{id}', [GalleriesController::class, 'show']);
Route::post('/galleries', [GalleriesController::class, 'store']);


//AUTHOR ROUTES
Route::get('/authors/{id}', [AuthorController::class, 'show']);
Route::get('/authorsGalleries/{id}', [AuthorController::class, 'index']);
// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'auth'
// ], function(){
//     Route::post('login', [AuthController::class, 'login']);
// });
