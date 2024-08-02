<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoomController;
use App\Models\UserRoomModel;
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


//user auth
Route::post('userRegister', [UserController::class, 'userRegister']);
Route::post('userLogin', [UserController::class, 'userLogin']);


//hotel auth 
Route::post('hotelLogin', [HotelController::class, 'hotelLogin']);
Route::post('hotelRegister', [HotelController::class, 'hotelRegister']);


//user profile
Route::post('updateUserProfile', [UserController::class, 'updateUserProfile']);
Route::get('getUserProfile/{id}', [UserController::class, 'getUserProfile']);

//room
Route::post('addRoom', [RoomController::class, 'addRoom']);
Route::post('updateRoom', [RoomController::class, 'updateRoom']);
Route::get('getRoomByHotelId/{id}', [RoomController::class, 'getRoomByHotelId']);
Route::get('getRooms', [RoomController::class, 'getRooms']);
Route::get('getMostPopularRooms', [RoomController::class, 'getMostPopularRooms']);



//user room
Route::post('reserveRoom', [UserRoomController::class, 'reserveRoom']);
Route::post('acceptRejectReservation', [UserRoomController::class, 'acceptRejectReservation']);
Route::get('getHotelReservations/{id}', [UserRoomController::class, 'getHotelReservations']);




