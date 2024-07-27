<?php

namespace App\Http\Controllers;

use App\Models\HotelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class HotelController extends Controller
{
    public function hotelLogin(Request $request)
    {
        $hotel = HotelModel::where('email', $request->email)->first();

        if ($hotel) {
            if (Hash::check($request->password, $hotel->password)) {
                return response()->json([
                    'hotel data' => $hotel,
                    'token' => $hotel->createToken('token')->plainTextToken
                ], 200);
            }
            return response()->json(['message' => "password wrong"], 400);
        } else {
            return response()->json(['message' => "email is not found"], 400);
        }
        return response()->json([], 500);
    }
    public function hotelRegister(Request $request)
    {
        if (HotelModel::where('email', $request->email)->first()) {
            return response()->json(['message' => "email is already in use"], 400);
        }
        if (HotelModel::where('name', $request->name)->first()) {
            return response()->json(['message' => "name is already in use"], 400);
        }
        $hotel = new HotelModel;
        $hotel->name = $request->name;
        $hotel->email = $request->email;
        $hotel->password = Hash::make($request->password);
        $hotel->lat = $request->lat;
        $hotel->long = $request->long;
        $hotel->desc = $request->desc;
        $hotel->location_desc = $request->location_desc;
        $file =  $request->file('image')->store('public');
        $hotel->image = basename($file);
        $res = $hotel->save();
        if ($res) {
            return response()->json([
                'hotel data' => $hotel,
                'token' => $hotel->createToken('token')->plainTextToken
            ], 200);
        }

        return response()->json([], 500);
    }
}
