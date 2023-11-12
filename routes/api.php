<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
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

Route::post('/login', function(Request $request) {
    $auth = new AuthController();

    return $auth->login($request);
});

Route::get('/users', function(UserController $controller) {
    return $controller->index();
})->middleware(['auth:sanctum', 'only_admin']);

Route::get('/users/{id}', function(UserController $controller, Request $request) {
    return $controller->show($request);
})->middleware(['auth:sanctum', 'user_by_id']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
