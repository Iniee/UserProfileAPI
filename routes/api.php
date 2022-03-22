<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
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
// Public Route
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/profile/list', [ProfileController::class, 'index']);



//Protected Route
Route::group(['middleware'=>['auth:sanctum']], function () {

Route::put('/profile/{id}', [ProfileController::class, 'update']);
Route::delete('/profile/{id}', [ProfileController::class, 'destroy']);
Route::get('profile/restore/{id}', [ProfileController::class, 'restore']);
Route::get('profile/restore-all', [ProfileController::class, 'restoreAll']);
Route::delete('/delete/profile/{id}', [ProfileController::class, 'forcedestroy']);
});

Route::get('/user', function (Request $request ){
 return $request->user();
})->middleware('auth:api');

