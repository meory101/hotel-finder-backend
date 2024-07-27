<?php

namespace App\Http\Controllers;

use App\Models\OTPModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function userLogin(Request $request)
    {
        $otp  = new OTPModel;
        if ($request->type == 0) {
            $client =  UserModel::where('number', $request->number)->first();
            $otp = OTPModel::where('user_id', $client->id)->orderBy('created_at', 'desc')->first();
        }
        if ($otp) {
            if ($otp->otp_code == $request->otp_code) {


                return response()->json(['token' => $client->createToken('token')->plainTextToken], 200);
            } else {
                return response()->json(['message' => 'otp is wrong'], 400);
            }
        }

        return response()->json([], 500);
    }


    public function updateUserProfile(Request $request)
    {
        $user = UserModel::find($request->id);
        if ($user) {
            if ($request->name) {
                $user->name = $request->name;
            }
            if ($request->email) {
                $user->email = $request->email;
            }

            if ($request->gender) {
                $user->gender = $request->gender;
            }
            if ($request->birthdate) {
                $user->birthdate = $request->birthdate;
            }
            if ($request->file('image')) {
                if ($user->image) {
                    Storage::delete('public/' . $user->image);
                }
                $file =  $request->file('image')->store('public');
                $user->image = basename($file);
            }
            $user = $user->save();
            if ($user) {
                return response()->json([], 200);
            }
        } else {
            return response()->json(['message' => 'user not found'], 400);
        }
        return response()->json([], 500);
    }

    public function getUserProfile( $id)
    {
        $user = UserModel::find($id);
        if ($user) {
            return response()->json($user, 200);
        }
        return response()->json([], 500);
    }
}
