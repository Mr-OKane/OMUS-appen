<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

    // address
    Route::get('addresses/deleted',[AddressController::class, 'deleted']);
    Route::post('addresses/{id}/restore',[AddressController::class, 'restore']);
    Route::delete('addresses/{id}/forceDelete', [AddressController::class, 'forceDelete']);

    // Chat
    Route::get('chats/deleted', [ChatController::class, 'deleted']);
    Route::post('chats/{id}/restore', [ChatController::class, 'restore']);
    Route::delete('chats/{id}/forceDelete', [ChatController::class, 'forceDelete']);

    // Chat room
    Route::get('chat-rooms/deleted', [ChatRoomController::class, 'deleted']);
    Route::post('chat-rooms/{id}/restore', [ChatRoomController::class, 'restore']);
    Route::delete('chat-rooms/{id}/forceDelete', [ChatRoomController::class, 'forceDelete']);

    // city
    Route::get('cities/deleted',[CityController::class, 'deleted']);
    Route::post('cities/{id}/restore',[CityController::class, 'restore']);
    Route::delete('cities/{id}/forceDelete',[CityController::class,'forceDelete']);

    // Instrument
    Route::get('instruments/deleted',[InstrumentController::class,'deleted']);
    Route::post('instruments/{id}/restore',[InstrumentController::class, 'restore']);
    Route::delete('instruments/{id}/forceDelete',[InstrumentController::class, 'forceDelete']);

    // Order
    Route::get('orders/deleted',[OrderController::class, 'deleted']);
    Route::post('orders/{id}/restore',[OrderController::class, 'restore']);
    Route::delete('orders/{id}/forceDelete',[OrderController::class, 'forceDelete']);

    // Product
    Route::get('products/deleted',[ProductController::class,'deleted']);
    Route::post('products/{id}/restore',[ProductController::class,'restore']);
    Route::delete('products/{id}/forceDelete',[ProductController::class,'forceDelete']);

    // Role
    Route::get('roles/deleted', [RoleController::class,'deleted']);
    Route::post('roles/{id}/restore', [RoleController::class, 'restore']);
    Route::delete('roles/{id}/forceDelete', [RoleController::class, 'forceDelete']);

    // Sheet
    Route::get('sheets/deleted', [SheetController::class,'deleted']);
    Route::post('sheets/{id}/restore', [SheetController::class,'restore']);
    Route::delete('sheets/{id}/forceDelete', [SheetController::class, 'forceDelete']);

    // Status
    Route::get('statuses/deleted',[StatusController::class,'deleted']);
    Route::post('statuses/{id}/restore',[StatusController::class,'restore']);
    Route::delete('statuses/{id}/forceDelete',[StatusController::class,'forceDelete']);

    // Team
    Route::get('teams/deleted', [TeamController::class,'deleted']);
    Route::post('teams/{id}/restore', [TeamController::class,'restore']);
    Route::delete('teams/{id}/forceDelete',[TeamController::class,'forceDelete']);

    // User
    Route::get('users/deleted',[UserController::class, 'deleted']);
    Route::post('users/{id}/restore',[UserController::class, 'restore']);
    Route::delete('users/{id}/forceDelete',[UserController::class,'forceDelete']);

    Route::apiResource('addresses',AddressController::class);
    Route::apiResource('cake-arrengements', CakeArrengementController::class);
    Route::apiResource('chats', ChatController::class);
    Route::apiResource('chat-rooms',ChatRoomController::class);
    Route::apiResource('cities',CityController::class);
    Route::apiResource('ideas',IdeaController::class);
    Route::apiResource('instruments',InstrumentController::class);
    Route::apiResource('messages',MessageController::class);
    Route::apiResource('notifications',NotificationController::class);
    Route::apiResource('orders',OrderController::class);
    Route::apiResource('permissions',PermissionController::class);
    Route::apiResource('practice-dates',PracticeDateController::class);
    Route::apiResource('products',ProductController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('sheets',SheetController::class);
    Route::apiResource('statuses',StatusController::class);
    Route::apiResource('teams',TeamController::class);
    Route::apiResource('users',UserController::class);
    Route::apiResource('zip-codes',ZipCodeController::class);
});
