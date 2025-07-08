<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users=User::where('type','USER')->get();
        if(!$users){
            return response()->json(['message'=>'Not found users']);
        }
        return response()->json($users,200);
    }
}
