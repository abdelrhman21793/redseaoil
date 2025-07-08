<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Troubleshoot;
use Illuminate\Http\Request;

class TroubleshootController extends Controller
{
    public function index()
    {
        $troubleshoots=Troubleshoot::with(['troubleshoot_structures.troubleshoot_structure_descriptions' => function($query){
            $query->whereHas('user',function ($query){
                $query->where('type','SUPER_ADMIN');
            });
        }])->get();
        if($troubleshoots){
            return response()->json($troubleshoots,200);
        }
        return response()->json(['message'=> 'Troubleshoots Empty'],200);
    }
}
