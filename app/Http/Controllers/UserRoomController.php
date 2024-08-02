<?php

namespace App\Http\Controllers;

use App\Models\HotelModel;
use App\Models\RoomModel;
use App\Models\UserRoomModel;
use Illuminate\Http\Request;

class UserRoomController extends Controller
{

    // 0 pending 1 accepted 2 rejected
    public function getHotelReservations($id)
    {
    //     $message =[];
    //     $rooms = UserRoomModel::all();
    //    for($i=0;$i<$rooms;$i++){
    //     if($rooms[$i]->hotel->id == $id){
    //         array_push($message,$rooms[$i]);
    //     }
    //    }
    // return $reservation;
    }

    public function reserveRoom(Request $request)
    {
        $user_room = new UserRoomModel;
        $user_room->date  = $request->date;
        $user_room->room_id  = $request->room_id;
        $user_room->user_id  = $request->user_id;
        $user_room = $user_room->save();
        if ($user_room) {
            return response()->json([], 200);
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
