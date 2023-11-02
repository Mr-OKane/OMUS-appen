<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CakeArrangementController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PracticeDateController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SheetController;
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

Route::post('login',[\App\Http\Controllers\Auth\LoginController::class,'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function (){

    Route::get('logout',[\App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');

    // address
    Route::get('addresses/deleted',[AddressController::class, 'deleted']);
    Route::get('addresses/{id}/restore',[AddressController::class, 'restore']);
    Route::delete('addresses/{id}/forceDelete', [AddressController::class, 'forceDelete']);

    // Chat
    Route::get('chats/deleted', [ChatController::class, 'deleted']);
    Route::get('chats/{id}/restore', [ChatController::class, 'restore']);
    Route::delete('chats/{id}/forceDelete', [ChatController::class, 'forceDelete']);

    // Chat room
    Route::get('chat-rooms/deleted', [ChatRoomController::class, 'deleted']);
    Route::get('chat-rooms/{id}/restore', [ChatRoomController::class, 'restore']);
    Route::delete('chat-rooms/{id}/forceDelete', [ChatRoomController::class, 'forceDelete']);

    // city
    Route::get('cities/deleted',[CityController::class, 'deleted']);
    Route::get('cities/{id}/restore',[CityController::class, 'restore']);
    Route::delete('cities/{id}/forceDelete',[CityController::class,'forceDelete']);

    // Instrument
    Route::get('instruments/deleted',[InstrumentController::class,'deleted']);
    Route::get('instruments/{id}/restore',[InstrumentController::class, 'restore']);
    Route::delete('instruments/{id}/forceDelete',[InstrumentController::class, 'forceDelete']);

    // Message
    Route::get('messages/chat/{chat_id}',[MessageController::class,'chatMessages']);

    // Order
    Route::get('orders/deleted',[OrderController::class, 'deleted']);
    Route::get('orders/{id}/restore',[OrderController::class, 'restore']);
    Route::delete('orders/{id}/forceDelete',[OrderController::class, 'forceDelete']);

    // Product
    Route::get('products/deleted',[ProductController::class,'deleted']);
    Route::get('products/{id}/restore',[ProductController::class,'restore']);
    Route::delete('products/{id}/forceDelete',[ProductController::class,'forceDelete']);

    // Role
    Route::put('roles/{id}/rolePermission',[RoleController::class,'rolePermissionsUpdate']);
    Route::get('roles/deleted', [RoleController::class,'deleted']);
    Route::get('roles/{id}/restore', [RoleController::class, 'restore']);
    Route::delete('roles/{id}/forceDelete', [RoleController::class, 'forceDelete']);

    // Sheet
    Route::get('sheets/deleted', [SheetController::class,'deleted']);
    Route::get('sheets/{id}/restore', [SheetController::class,'restore']);
    Route::delete('sheets/{id}/forceDelete', [SheetController::class, 'forceDelete']);

    // Team
    Route::put('teams/{id}/teamUserUpdate', [TeamController::class, 'teamUserUpdate']);
    Route::get('teams/deleted', [TeamController::class,'deleted']);
    Route::get('teams/{id}/restore', [TeamController::class,'restore']);
    Route::delete('teams/{id}/forceDelete',[TeamController::class,'forceDelete']);

    // User
    Route::put('users/{id}/userInstrumentUpdate', [UserController::class, 'userInstrumentUpdate']);
    Route::put('users/{id}/userPasswordUpdate', [UserController::class, 'userPasswordUpdate']);
    Route::put('users/{id}/userRoleUpdate', [UserController::class, 'userRoleUpdate']);
    Route::put('users/{id}/userTeamUpdate', [UserController::class, 'userTeamUpdate']);
    Route::get('users/deleted',[UserController::class, 'deleted']);
    Route::get('users/{id}/restore',[UserController::class, 'restore']);
    Route::delete('users/{id}/forceDelete',[UserController::class,'forceDelete']);

    Route::apiResource('addresses',AddressController::class);
    Route::apiResource('cake-arrangements', CakeArrangementController::class);
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
    Route::apiResource('teams',TeamController::class);
    Route::apiResource('users',UserController::class);
    Route::apiResource('zip-codes',ZipCodeController::class);
});
