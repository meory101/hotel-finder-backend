<?php

namespace App\Http\Controllers;

use App\Models\ImageModel;
use App\Models\RateModel;
use App\Models\RoomModel;
use App\Models\RoomToolModel;
use App\Models\RoomViewModel;
use App\Models\ToolModel;
use App\Models\ViewModel;
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
        for ($i = 0; $i < count($request->files); $i++) {

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


        if ($rooms) {
            return response()->json($message, 200);
        }
        return response()->json([], 500);
    }


    public function  getRooms()
    {
        $rooms = RoomModel::all();
        $message = [];
        $vnames = [];
        $tnames = [];
        for ($i = 0; $i < count($rooms); $i++) {
            $view =   RoomViewModel::where('room_id', $rooms[$i]->id)->get();
            $tools = RoomToolModel::where('room_id', $rooms[$i]->id)->get();
            for ($j = 0; $j < count($view); $j++) {
                array_push($vnames, ViewModel::where('id', $view[$j]->view_id)->first());
            }
            for ($t = 0; $t < count($tools); $t++) {
                array_push($tnames, ToolModel::where('id', $tools[$t]->tool_id)->first());
            }
            array_push($message, [
                'room' => $rooms[$i],
                'image' => ImageModel::where('room_id', $rooms[$i]->id)->get(),

                'rate'
                => RateModel::where('room_id', $rooms[$i]->id)->get()->pluck('value')->avg(),
                'view' => $view,
                'vnames' => $vnames,
                'tnames' => $tnames,
                'tool'
                => RoomToolModel::where('room_id', $rooms[$i]->id)->get(),
            ]);
        }
        if ($rooms) {
            return json_encode($message);
        }
        return response()->json([], 500);
    }


    public function getMostPopularRooms()
    {

        $rooms = RoomModel::all();
        $message = [];
        $vnames = [];
        $tnames = [];
        for ($i = 0; $i < count($rooms); $i++) {
            $view =   RoomViewModel::where('room_id', $rooms[$i]->id)->get();
            $tools = RoomToolModel::where('room_id', $rooms[$i]->id)->get();
            for ($j = 0; $j < count($view); $j++) {
                array_push($vnames, ViewModel::where('id', $view[$j]->view_id)->first());
            }
            for ($t = 0; $t < count($tools); $t++) {
                array_push($tnames, ToolModel::where('id', $tools[$t]->tool_id)->first());
            }
            array_push($message, [
                'room' => $rooms[$i],
                'image' => ImageModel::where('room_id', $rooms[$i]->id)->get(),

                'rate'
                => RateModel::where('room_id', $rooms[$i]->id)->get()->pluck('value')->avg(),
                'view' => $view,
                'vnames' => $vnames,
                'tnames' => $tnames,
                'tool'
                => RoomToolModel::where('room_id', $rooms[$i]->id)->get(),
            ]);
        }
        usort($message, function ($a, $b) {
            return $b['rate'] <=> $a['rate'];
        });
        if ($rooms) {
            return json_encode($message);
        }
        return response()->json([], 500);
    }
}
