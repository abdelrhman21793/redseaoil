<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $tests=Test::with(['test_structures.test_structure_descriptions' => function($query){
            $query->whereHas('user',function ($query){
                $query->where('type','SUPER_ADMIN');
            });
        }])->get();
        if($tests){
            return response()->json($tests,200);
        }
        return response()->json(['message'=> 'Tests Empty'],200);
    }
}
