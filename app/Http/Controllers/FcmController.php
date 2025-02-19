<?php

namespace App\Http\Controllers;

use App\FcmToken;
use Illuminate\Http\Request;

class FcmController extends Controller
{
    public function __invoke(Request $request)
    {
        $token = $request->token;
        $tokenModel = FcmToken::where('token', $token)->first();
        if(is_null($tokenModel))
            $tokenModel = FcmToken::create(['token' => $token]);

        $user = auth()->guard('customer')->user();
        if(!is_null($user) && is_null($tokenModel->customer_id))
            $tokenModel->update(['customer_id' => $user->id]);
    }
}
