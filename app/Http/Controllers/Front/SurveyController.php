<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys=Survey::with(['survey_structures.survey_structure_descriptions' => function($query){
            $query->whereHas('user',function ($query){
                $query->where('type','SUPER_ADMIN');
            });
        }])->get();
        if($surveys){
            return response()->json($surveys,200);
        }
        return response()->json(['message'=> 'Surveys Empty'],200);
    }
}
