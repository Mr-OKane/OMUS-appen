<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostalCodeController;
use App\Http\Controllers\PracticeDateController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;

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


/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::controller(LoginController::class)->group(function (){
    Route::post('/login', 'authentiacte');
    Route::delete('/logout', 'logout');
});

//absence routing
Route::controller(AbsenceController::class)->group(function () {
    Route::get('/absences','index')->middleware('auth:sanctum');
    Route::post('/absences','store');
    Route::delete('/absence/{id}','delete');
});

//address routing
Route::controller(AddressController::class)->group(function () {
    Route::get('/addresses','index');
    Route::post('/addresses', 'store');
    Route::get('/address/{id}','show');
    Route::put('/address/{id}','update');
    Route::delete('/address/{id}','delete');
});

//Chat routing
Route::controller(ChatController::class)->group(function () {
    Route::get('/chats','index');
    Route::get('/chats/deleted','deletedChats');
    Route::post('/chats','store');
    Route::get('/chat/{id}','show');
    Route::put('/chat/{id}','update');
    Route::delete('/chat/{id}','delete');
    Route::delete('/chat/{id}/force','forceDelete');
    Route::post('/chat/{id}/restore', 'restore');
});

//ChatRoom routing
Route::controller(ChatRoomController::class)->group(function (){
    Route::get('/chat-rooms','index');
    Route::get('/chat_rooms/deleted','deletedChatRooms');
    Route::post('/chat-room','store');
    Route::get('/chat_room/{id}','show');
    Route::put('/chat_room/{id}','update');
    Route::delete('/chat_room/{id}','delete');
    Route::delete('/chat_room/{id}/force','forceDelete');
    Route::post('/chat_room/{id}/restore', 'restore');
});

//Idea routing
Route::controller(IdeaController::class)->group(function () {
    Route::get('/ideas','index');
    Route::post('/ideas','store');
    Route::get('/idea/{id}','show');
    Route::put('/idea/{id}','update');
    Route::delete('/idea/{id}','delete');
});

//Instrument routing
Route::controller(InstrumentController::class)->group(function () {
    Route::get('/instruments','index');
    Route::get('/instruments/deleted','deletedInstruments');
    Route::post('/instruments','store');
    Route::get('/instrument/{id}','show');
    Route::put('/instrument/{id}','update');
    Route::delete('/instrument/{id}','delete');
    Route::delete('/instrument/{id}/force','forceDelete');
    Route::post('/instrument/{id}/restore','restore');
});

//Message routing
Route::controller(MessageController::class)->group(function () {
    Route::get('/messages','index');
    Route::post('/messages','store');
    Route::get('/message/{id}','show');
    Route::put('/message/{id}','update');
    Route::delete('/message/{id}','delete');
});

//Notification routing
Route::controller(NotificationController::class)->group(function () {
    Route::get('/notifications','index');
    Route::post('/notification','store');
    Route::get('/notification/{id}','show');
    Route::put('/notification/{id}','update');
    Route::delete('/notification/{id}','delete');
});

//Order routing
Route::controller(OrderController::class)->group(function () {
    Route::get('/orders','index');
    Route::get('/orders/deleted','deletedOrder');
    Route::post('/orders','store');
    Route::get('/order/{id}','show');
    Route::put('/order/{id}','update');
    Route::delete('/order/{id}','delete');
    Route::delete('/order/{id}/force', 'forceDelete');
    Route::post('/order/{id}/restore','restore');
});

//OrderStatus routing
Route::controller(OrderStatusController::class)->group(function () {
    Route::get('/order-statuses','index');
    Route::post('/order-statuses','store');
    Route::get('/order-status/{id}','show');
    Route::put('/order-status/{id}','update');
    Route::delete('/order-status/{id}','delete');
});

//Permission routing
Route::controller(PermissionController::class)->group(function () {
    Route::get('/permissions','index');
});

//PostalCode routing
Route::controller(PostalCodeController::class)->group(function () {
    Route::get('/postal-codes','index');
    Route::get('/postal-code/{id}','show');
});

//PracticeDate routing
Route::controller(PracticeDateController::class)->group(function () {
    Route::get('/practice-dates','index');
    Route::post('/practice-dates','store');
    Route::get('/practice-date/{id}','show');
    Route::put('/practice-date/{id}','update');
    Route::delete('/practice-date/{id}','delete');
});

//Product routing
Route::controller(ProductController::class)->group(function () {
    Route::get('/products','index');
    Route::get('/products/deleted','deletedProducts');
    Route::post('/products','store');
    Route::get('/product/{id}','show');
    Route::put('/product/{id}','update');
    Route::delete('/product/{id}','delete');
    Route::delete('/product/{id}/force','forceDelete');
    Route::post('/product/{id}/restore','restore');
});

//Role routing
Route::controller(RoleController::class)->group(function () {
    Route::get('/roles','index');
    Route::get('/roles/deleted','rolesDeleted');
    Route::get('/role/permissions','rolePermissions');
    Route::post('/roles','store');
    Route::get('/role/{id}','show');
    Route::put('/role/{id}/permissions','rolePermissionsUpdate');
    Route::put('/role/{id}','update');
    Route::delete('/role/{id}','delete');
    Route::delete('/role/{id}/force','forceDelete');
    Route::post('/role/{id}/restore','restore');
});

//Sheet routing
Route::controller(SheetController::class)->group(function () {
    Route::get('/sheets','index');
    Route::get('/sheets/deleted','deletedSheets');
    Route::post('/sheets','store');
    Route::get('/sheet/{id}','show');
    Route::delete('/sheet/{id}','delete');
    Route::delete('/sheet/{id}/force','forceDelete');
    Route::post('/sheet/{id}/restore', 'restore');
});

//Team routing
Route::controller(TeamController::class)->group(function () {
    Route::get('/teams','index');
    Route::get('/teams/deleted','deletedTeams');
    Route::get('/team/users','teamUserIndex');
    Route::post('/teams','store');
    Route::get('/team/{id}','show');
    Route::put('/team/{id}','update');
    Route::put('/team/{id}/users','teamUsersUpdate');
    Route::delete('/team/{id}','delete');
    Route::delete('/team/{id}','forceDelete');
    Route::post('/team/{id}','restore');
});

//User routing
Route::controller(UserController::class)->group(function () {
    Route::get('/users','index')->middleware('auth:sanctum');
    Route::get('/users/deleted','deletedUsers');
    Route::post('/users','store');
    Route::get('/user/{id}','show');
    Route::put('/user/{id}','update');
    Route::put('/user/{id}','userPasswordUpdate');
    Route::put('/user/{id}/role','userRoleUpdate');
    Route::put('/user/{id}/','userInstrumentsUpdate');
    Route::delete('/user/{id}','delete');
    Route::delete('/user/{id}','forceDelete');
    Route::post('/user/{id}','restore');
});

