<?php

namespace App\Http\Controllers;

use App\Models\OTPModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class OTPController extends Controller
{
    public function generateOTP(Request $request)
    {

        $otp = new OTPModel;
        $otp_code = random_int(100000, 999999);
        if ($request->type == 0) {
            $client =  new UserModel;
            $client = $client->where('number', $request->number)->first();
            if (!$client) {
                $client =  new UserModel;
                $client->number = $request->number;
                $client->save();
            }
            $otp->user_id
                = $client->id;
        }

        if ($otp->user_id) {
            $otp->otp_code = $otp_code;
            $result = $otp->save();
            if ($result) {
                return response()->json($otp, 200);
            }
        }


        return response()->json([], 500);
    }
}
