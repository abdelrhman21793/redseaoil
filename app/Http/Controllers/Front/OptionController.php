<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index()
    {
        $options=Option::with(['structures.structure_descriptions' => function($query){
            $query->whereHas('user',function ($query){
                $query->where('type','SUPER_ADMIN');
            });
        }])->get();
        if($options){
            return response()->json($options,200);
        }
        return response()->json(['message'=> 'Options Empty'],200);
    }
}
