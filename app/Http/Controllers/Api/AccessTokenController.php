<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email'=>'required|email|max:255',
            'password'=>'required|string|max:255',
            'device_name'=>'string|max:255'
        ]);
        $user=User::where('email',$request->email)->first();
        if($user && Hash::check($request->password,$user->password)){
            $device_name=$request->post('device_name',$request->userAgent());
            $token=$user->createToken($device_name);
            return Response::json([
                'code'=>100,
                'token'=>$token->plainTextToken,
                'user'=>$user
            ],201);
        }
        return Response::json([
            'code'=> 0,
            'message'=>'Invalid Credentials',
        ],401);
    }

    public function destroy($token = null)
    {
        $user=Auth::guard('sanctum')->user();
        if(null===$token){
            $user->currentAccessToken()->delete();
            return;
        }
        $personalAccessToken=PersonalAccessToken::findToken($token);
        if($user->id == $personalAccessToken->tokenable_id && get_class($user) == $personalAccessToken->tokenable_type)
        {
            $personalAccessToken->delete();
        }
    }
}
