<?php

namespace App\Http\Controllers;

use App\Models\HotelModel;
use App\Models\ImageModel;
use App\Models\RateModel;
use App\Models\RoomModel;
use App\Models\RoomToolModel;
use App\Models\RoomViewModel;
use App\Models\ToolModel;
use App\Models\ViewModel;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PhpParser\JsonDecoder;

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
        for ($i = 0; $i < count($request->view); $i++) {

            $view = new RoomViewModel;
            $view->view_id = $request->view[$i];
            $view->room_id = $room->id;
            $view = $view->save();
        }
        for ($i = 0; $i < count($request->tool); $i++) {
            $tool = new RoomToolModel;
            $tool->tool_id = $request->tool[$i];
            $tool->room_id = $room->id;
            $tool = $tool->save();
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
                'hotel' => HotelModel::find($rooms[$i]->hotel_id),

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
                => round(RateModel::where('room_id', $rooms[$i]->id)->get()->pluck('value')->avg(), 2),
                'view' => $view,
                'vnames' => $vnames,
                'tnames' => $tnames,
                'hotel' => HotelModel::find($rooms[$i]->hotel_id),
                'tool'
                => RoomToolModel::where('room_id', $rooms[$i]->id)->get(),
            ]);
        }

        if ($rooms) {
            return json_encode($message);
        }
        return response()->json([], 500);
    }

    public function  getRoomsByHotelId($id)
    {
        $rooms = RoomModel::where('hotel_id', $id)->get();
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
                => round(RateModel::where('room_id', $rooms[$i]->id)->get()->pluck('value')->avg(), 2),
                'view' => $view,
                'vnames' => $vnames,
                'tnames' => $tnames,
                'hotel' => HotelModel::find($rooms[$i]->hotel_id),

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
                => round(RateModel::where('room_id', $rooms[$i]->id)->get()->pluck('value')->avg(), 2),
                'view' => $view,
                'vnames' => $vnames,
                'tnames' => $tnames,
                'hotel' => HotelModel::find($rooms[$i]->hotel_id),
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


    public function getMostReleventRooms(Request $request)
    {
        $message = [];
        $vnames = [];
        $tnames = [];
        $response = Http::asForm()->post('http://10.2.0.2:5000/api/getMostReleventRooms', ['searchQuery' => $request->searchQuery ?? ""]);
        $response =  json_decode(($response)['releventRoomsIds'], true);
        $response =  $response['docno'];
        $ids = array_values($response);
        for ($i = 0; $i < count($ids); $i++) {
            $view =   RoomViewModel::where('room_id', $ids[$i])->get();
            $tools = RoomToolModel::where('room_id', $ids[$i])->get();
            for ($j = 0; $j < count($view); $j++) {
                array_push($vnames, ViewModel::where('id', $view[$j]->view_id)->first());
            }
            for ($t = 0; $t < count($tools); $t++) {
                array_push($tnames, ToolModel::where('id', $tools[$t]->tool_id)->first());
            }
            array_push($message, [
                'room' => RoomModel::find($ids[$i]),
                'image' => ImageModel::where('room_id', $ids[$i])->get(),

                'rate'
                => round(RateModel::where('room_id', $ids[$i])->get()->pluck('value')->avg(), 2),
                'view' => $view,
                'vnames' => $vnames,
                'tnames' => $tnames,
                'hotel' => RoomModel::find($ids[$i])->hotel_id,

                'tool'
                => RoomToolModel::where('room_id', $ids[$i])->get(),
            ]);
        }
        return
            array_map("unserialize", array_unique(array_map("serialize", $message)));
    }



    public function rateRoom(Request $request)
    {
        $rate  = new RateModel;
        $rate->value = $request->value;
        $rate->room_id = $request->room_id;
        $rate->user_id = $request->user_id;
        $rate = $rate->save();
        if ($rate) {
            return response()->json([], 200);
        }
        return response()->json([], 500);
    }
}
