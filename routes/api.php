<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Broadcast::routes(['prefix' => 'api', 'middleware' => ['auth:api']]);

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'chat'], function () {
        Route::get('all', [App\Http\Controllers\HomeController::class, 'all_chat']);
        Route::get('user', [App\Http\Controllers\HomeController::class, 'user_chat']);
    });
    Route::group(['prefix' => 'create'], function () {
        Route::post('server', [App\Http\Controllers\HomeController::class, 'store_server']);
        Route::post('chat', [App\Http\Controllers\HomeController::class, 'store_chat']);
        Route::post('groupchat', [App\Http\Controllers\HomeController::class, 'group_chat']);
    });
    Route::group(['prefix' => 'user'], function () {
        Route::get('list', [App\Http\Controllers\API\UserController::class, 'index']);
        Route::post('create', [App\Http\Controllers\API\UserController::class, 'store']);
        Route::put('update/{id}', [App\Http\Controllers\API\UserController::class, 'update']);
        Route::delete('delete/{id}', [App\Http\Controllers\API\UserController::class, 'destroy']);
    });
    Route::group(['prefix' => 'permission'], function () {
        Route::get('list', [App\Http\Controllers\API\PermissionController::class, 'index']);
        Route::get('all', [App\Http\Controllers\API\PermissionController::class, 'index_all']);
        Route::post('create', [App\Http\Controllers\API\PermissionController::class, 'store']);
        Route::put('update/{id}', [App\Http\Controllers\API\PermissionController::class, 'update']);
        Route::delete('delete/{id}', [App\Http\Controllers\API\PermissionController::class, 'destroy']);
    });
    Route::group(['prefix' => 'role'], function () {
        Route::get('list', [App\Http\Controllers\API\RoleController::class, 'index']);
        Route::get('all', [App\Http\Controllers\API\RoleController::class, 'index_all']);
        Route::post('create', [App\Http\Controllers\API\RoleController::class, 'store']);
        Route::put('update/{id}', [App\Http\Controllers\API\RoleController::class, 'update']);
        Route::delete('delete/{id}', [App\Http\Controllers\API\RoleController::class, 'destroy']);
    });
    Route::group(['prefix' => 'registrar'], function () {
        Route::get('list', [App\Http\Controllers\API\RegistrarController::class, 'index']);
        Route::get('all', [App\Http\Controllers\API\RegistrarController::class, 'index_all']);
        Route::post('create', [App\Http\Controllers\API\RegistrarController::class, 'store']);
        Route::put('update/{id}', [App\Http\Controllers\API\RegistrarController::class, 'update']);
        Route::delete('delete/{id}', [App\Http\Controllers\API\RegistrarController::class, 'destroy']);
    });
    Route::group(['prefix' => 'program'], function () {
        Route::get('list', [App\Http\Controllers\API\ProgramController::class, 'index']);
        Route::get('all', [App\Http\Controllers\API\ProgramController::class, 'index_all']);
        Route::post('create', [App\Http\Controllers\API\ProgramController::class, 'store']);
        Route::put('update/{id}', [App\Http\Controllers\API\ProgramController::class, 'update']);
        Route::delete('delete/{id}', [App\Http\Controllers\API\ProgramController::class, 'destroy']);
    });
});
