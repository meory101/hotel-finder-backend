<?php

namespace App\Http\Controllers;

use App\Models\OTPModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PhpParser\JsonDecoder;

class UserController extends Controller
{
    public function userLogin(Request $request)
    {
        $user = UserModel::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'user data' => $user,
                    'token' => $user->createToken('token')->plainTextToken
                ], 200);
            }
            return response()->json(['message' => "password wrong"], 400);
        } else {
            return response()->json(['message' => "email is not found"], 400);
        }
        return response()->json([], 500);
    }
    public function userRegister(Request $request)
    {
        if (UserModel::where('email', $request->email)->first()) {
            return response()->json(['message' => "email is already in use"], 400);
        }
        if (UserModel::where('name', $request->name)->first()) {
            return response()->json(['message' => "name is already in use"], 400);
        }
        $user = new UserModel;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $res = $user->save();
        if ($res) {
            return response()->json([
                'user data' => $user,
                'token' => $user->createToken('token')->plainTextToken
            ], 200);
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
            if ($request->number) {
                $user->number = $request->number;
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

    public function getUserProfile($id)
    {
        $user = UserModel::find($id);
        if ($user) {
            return response()->json($user, 200);
        }
        return response()->json([], 500);
    }
}
