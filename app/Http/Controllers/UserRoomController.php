<?php

namespace App\Http\Controllers;

use App\Models\HotelModel;
use App\Models\ImageModel;
use App\Models\RoomModel;
use App\Models\UserRoomModel;
use Illuminate\Http\Request;

class UserRoomController extends Controller
{

    // 0 pending 1 accepted 2 rejected
    public function getHotelReservations($id)
    {
        $message = [];
        $rooms = RoomModel::where('hotel_id', $id)->get();
        for ($i = 0; $i < count($rooms); $i++) {
            array_push($message, [
                'room' => $rooms[$i],
                'reservations' => UserRoomModel::where('room_id', $rooms[$i]->id)->get()
            ]);
        }
            if($message){
            return response()->json($message, 200);

            }
        return response()->json([], 500);
    }

    public function reserveRoom(Request $request)
    {
        $user_room = new UserRoomModel;
        $user_room->date  = $request->date;
        $user_room->nights  = $request->nights;
        $user_room->room_id  = $request->room_id;
        $user_room->user_id  = $request->user_id;
        $user_room = $user_room->save();
        if ($user_room) {
            return response()->json([], 200);
        }
        return response()->json([], 500);
    }

    public function getUserReservations($id)
    {
        $message = [];
        $user_room =  UserRoomModel::where('user_id', $id)->get();
        for ($j = 0; $j < count($user_room); $j++) {
            array_push(
                $message,
                [
                    'data' => $user_room[$j],
                    'image' =>  ImageModel::where('room_id', $user_room[$j]->room_id)->get(),
                    'room' => RoomModel::where('id', $user_room[$j]->room_id)->first()
                ]
            );
        }
        if ($user_room) {
            return response()->json($message, 200);
        }
        return response()->json([], 500);
    }
    public function acceptRejectReservation(Request $request)
    {
        $user_room = UserRoomModel::find($request->id);
        $user_room->type = $request->type;
        if ($request->file('file')) {
            $file =  $request->file('file')->store('public');
            $user_room->file = basename($file);
        }
        $user_room = $user_room->save();
        if ($user_room) {
            return response()->json([], 200);
        }
        return response()->json([], 500);
    }
}
