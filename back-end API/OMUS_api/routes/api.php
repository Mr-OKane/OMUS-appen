<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CakeArrengementController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PracticeDateController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZipCodeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('authenticaiton',[\App\Http\Controllers\Auth\LoginController::class,'authentiacte']);

Route::middleware('auth:sanctum')->group(function (){

    Route::get('logout',[\App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');

    Route::apiResource('addresses',AddressController::class);
    Route::apiResource('cakeArrengements', CakeArrengementController::class);
    Route::apiResource('chats', ChatController::class);
    Route::apiResource('chatRooms',ChatRoomController::class);
    Route::apiResource('cities',CityController::class);
    Route::apiResource('ideas',IdeaController::class);
    Route::apiResource('instruments',InstrumentController::class);
    Route::apiResource('messages',MessageController::class);
    Route::apiResource('notifications',NotificationController::class);
    Route::apiResource('orders',OrderController::class);
    Route::apiResource('permissions',PermissionController::class);
    Route::apiResource('practiceDates',PracticeDateController::class);
    Route::apiResource('products',ProductController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('sheets',SheetController::class);
    Route::apiResource('statuses',StatusController::class);
    Route::apiResource('teams',TeamController::class);
    Route::apiResource('users',UserController::class);
    Route::apiResource('zipCodes',ZipCodeController::class);
});
