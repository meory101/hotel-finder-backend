<?php

namespace App\Http\Controllers;

use App\Models\ImageModel;
use App\Models\RateModel;
use App\Models\RoomModel;
use App\Models\RoomToolModel;
use App\Models\RoomViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function addRoom(Request $request)
    {
        $room = new RoomModel;
        $room->name = $request->name;
        $room->desc = $request->desc;
        $room->price = $request->price;
        $room->capacity = $request->capacity;
        $room->hotel_id = $request->hotel_id;
        $res = $room->save();
        for ($i = 0; $i< count($request->files); $i++) {

            $file = $request->file('image' . $i)->store('public');
            $image = new ImageModel;
            $image->image = basename($file);
            $image->room_id = $room->id;
            $image = $image->save();
        }

        if ($res) {
            return response()->json([], 200);
        }
        return response()->json([], 500);
    }

    public function updateRoom(Request $request)
    {
        $room =  RoomModel::find($request->id);
        if ($request->name) {
            $room->name = $request->name;
        }
        if ($request->desc) {
            $room->desc = $request->desc;
        }
        if ($request->price) {
            $room->price = $request->price;
        }
        if ($request->capacity) {
            $room->capacity = $request->capacity;
        }
        $room = $room->save();
        if ($room) {
            return response()->json([], 200);
        }
        return response()->json([], 500);
    }


    public function getRoomByHotelId($id)
    {
     
        $rooms = RoomModel::where('hotel_id', $id)->get();
        $message = [];
        for($i=0;$i<count($rooms);$i++){
        array_push($message,[
            'room' => $rooms[$i],
            'rate'
                => RateModel::where('room_id', $rooms[$i]->id)->get()->pluck('value')->avg(),
            'view'=> RoomViewModel::where('room_id',$rooms[$i]->id)->get(),
            'tool'
                => RoomToolModel::where('room_id', $rooms[$i]->id)->get(),
        ]);
        
        }
    

        if ($rooms) {
            return response()->json($message, 200);
        }
        return response()->json([], 500);
    }


    public function  getRooms(){
        $rooms = RoomModel::all();
        if ($rooms) {
            return response()->json($rooms, 200);
        }
        return response()->json([], 500);
    }


    public function getMostPopularRooms()
    {

        $rooms = RoomModel::all();
        $message = [];
        for ($i = 0; $i < count($rooms); $i++) {
            array_push($message, [
                'room' => $rooms[$i],
                'rate'
                => RateModel::where('room_id', $rooms[$i]->id)->get()->pluck('value')->avg(),
                'view' => RoomViewModel::where('room_id', $rooms[$i]->id)->get(),
                'tool'
                => RoomToolModel::where('room_id', $rooms[$i]->id)->get(),
            ]);
        }

        usort($message, function ($a, $b) {
            return $b['rate'] <=> $a['rate'];
        });
        if ($rooms) {
            return response()->json($message, 200);
        }
        return response()->json([], 500);
    }







        
}
